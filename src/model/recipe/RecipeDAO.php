<?php

namespace vrklk\model\recipe;

class RecipeDAO extends \vrklk\base\model\BaseDAO implements \vrklk\model\interfaces\iRecipeDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getHomeRecipes(int $amount, int $page_number): array
    {
        // retrieves amount of recipe_id's, offset by page_number, from DB

        $get_home_recipes_query = '
            SELECT id
            FROM recipes
            ORDER BY date DESC
            LIMIT :amount OFFSET :offset;
        ';
        $parameters = ["amount" => [$amount, true], "offset" => [$amount * ($page_number - 1), true]];

        $query_result = $this->crud->selectMore($get_home_recipes_query, $parameters);
        $home_recipes_array = [];
        foreach ($query_result as $entry) {
            $home_recipes_array[] = $entry['id'];
        }

        return $home_recipes_array;
    }

    public function getFavoriteRecipes(
        int $amount,
        int $page_number,
        int $user_id
    ): array {
        // retrieves amount of recipe_id's, offset by page_number, from DB
        // where recipe_id is a favorite for user_id

        $get_favorite_recipes_query = '
            SELECT id
            FROM recipes r
            INNER JOIN favorites f ON r.id = f.recipe_id
            WHERE f.user_id = :user_id
            ORDER BY date DESC
            LIMIT :amount OFFSET :offset;
        ';
        $parameters = ["amount" => [$amount, true], "offset" => [$amount * ($page_number-1), true], 'user_id' => [$user_id, true]];

        $query_result = $this->crud->selectMore($get_favorite_recipes_query, $parameters);
        $favorite_recipes_array = [];
        foreach ($query_result as $entry) {
            $favorite_recipes_array[] = $entry['id'];
        }

        return $favorite_recipes_array;
    }

    public function getSearchRecipes(
        int $amount,
        int $page_number,
        string $search_query
    ): array {
        // retrieves amount of recipe_id's, offset by page_number, from DB
        // where recipe_id is a valid match for query

        $search_query_tester = '';
        $search_parameters = [];
        $test_elements = ['recipes.title', 'recipes.blurb', 'recipes.descr', 'cuisines.name', 'ingredients.name', 'users.name', 'recipes.type'];

        $i = 0;
        foreach ($test_elements as $element){
            $search_query_tester .= empty($search_query_tester) ? '' : ' OR ';
            $search_query_tester .= $element . ' LIKE :search_query' . $i;
            $search_parameters['search_query' . $i] = ['%' . $search_query . '%', true];
            $i++;
        }

        $get_search_recipes_query = '
            SELECT DISTINCT recipes.id
            FROM recipes
            INNER JOIN cuisines ON recipes.cuisine_id = cuisines.id
            INNER JOIN users ON recipes.user_id = users.id
            INNER JOIN recipe_ingredients ON recipe_ingredients.recipe_id = recipes.id
            INNER JOIN ingredients ON recipe_ingredients.ingredient_id = ingredients.id
            WHERE '. $search_query_tester .'
            ORDER BY date DESC
            LIMIT :amount OFFSET :offset;
        ';
        $base_parameters = ["amount" => [$amount, true], "offset" => [$amount * ($page_number - 1), true]];
        $parameters = array_merge($base_parameters, $search_parameters);

        $query_result = $this->crud->selectMore($get_search_recipes_query, $parameters);
        $search_recipes_array = [];
        foreach ($query_result as $entry) {
            $search_recipes_array[] = $entry['id'];
        }

        return $search_recipes_array;
    }

    public function getRecipeDetails(int $recipe_id): array
    {
        // includes rating, price, calories, cuisine name, and author name
        
        // 1. get the basic values
        // TODO check if the function still works with the lookup
        $get_recipe_query = '
            SELECT r.title AS title, r.img AS img, r.blurb AS blurb, r.people AS people, l.display AS display, r.descr AS desct, AVG(ra.rating) AS rating, c.name AS cuisine, u.name AS author
            FROM recipes r
            INNER JOIN ratings ra ON r.id = ra.recipe_id
            INNER JOIN cuisines c ON r.cuisine_id = c.id
            INNER JOIN users u ON r.user_id = u.id
            INNER JOIN lookup l ON (l.group = "recipe_types" AND r.type = l.value)
            WHERE r.id = :recipe_id
            GROUP BY r.id;
        ';
        $parameters = ["recipe_id" => [$recipe_id, true]];
        $recipe_result = $this->crud->selectOne($get_recipe_query, $parameters);


        // 2. get the products for the optimal price
        $product_dao = new \vrklk\model\recipe\ProductDAO($this->crud);
        
        //get ingredients
        $recipe_ingredient_query = '
            SELECT i.id AS id, (ri.quantity * m.quantity) AS quantity_needed
            FROM ingredients i
            INNER JOIN recipe_ingredients ri ON ri.ingredient_id = i.id
            INNER JOIN recipes r ON ri.recipe_id = r.id
            INNER JOIN measures m ON ri.measure_id = m.id
            WHERE r.id = :recipe_id;
        ';
        $recipe_ingredients = $this->crud->selectAsPairs($recipe_ingredient_query, $parameters);

        $total_price = 0;
        foreach($recipe_ingredients as $ingredient_id => $required_quantity) {
            $price_product_array = $product_dao->getIngredientProduct($ingredient_id, $required_quantity);
            if ($price_product_array) {
                $products_by_ingredients[$ingredient_id] = $price_product_array;
                $total_price += $price_product_array['price'];
            }
        }
        $recipe_result['price'] = $total_price;

        // 3. get the total calories
        $calories = $this->getCalories($products_by_ingredients, $recipe_id);
        $recipe_result['calories'] = $calories;

        return $recipe_result;
    }


    //private functions
    private function getCalories($products_by_ingredients, $recipe_id): float {
        // step 1: create temporary table for product ID's & amounts
        $create_product_amounts_table = '
            CREATE TEMPORARY TABLE product_amounts (
                product_id INT(11) PRIMARY KEY,
                amount INT(11)
            );
        ';
        $this->crud->executeQuery($create_product_amounts_table);

        // step 2: insert the product ID's & amounts into the temporary table
        
        //TODO make this work well with product output
        $product_insert_values = '';
        foreach($products_by_ingredients as $ingredient) {
            $product_list = $ingredient['products'];
            foreach ($product_list as $product_id => $product_amount) {
                $product_insert_values .= (empty($product_insert_values)) ? '' : ', ';
                $product_insert_values .= '("' . $product_id . '","' . $product_amount . '")';
            }
        }
        $insert_product_amounts_query = 'INSERT INTO product_amounts (product_id, amount) VALUES
            ' . $product_insert_values . ';';
        $this->crud->doInsert($insert_product_amounts_query);


        // step 3: prepare the query to get the total product quantity per ingredient
        $total_product_quantity_query = '
            SELECT p.ingredient_id AS ingredient_id, SUM(p.quantity * pa.amount * m.quantity) AS total_quantity
            FROM product_amounts pa
            INNER JOIN products p ON pa.product_id = p.id
            INNER JOIN measures m ON p.measure_id = m.id
            GROUP BY p.ingredient_id
        ';

        // step 4: prepare the query that calculates all the calories and adds them together.
        $get_calories_query = '
            SELECT SUM((ri.quantity * mri.quantity) / t.total_quantity * pa.amount * p.calories) as total_calories
            FROM products p
            INNER JOIN (
                ' . $total_product_quantity_query . '
            ) t ON t.ingredient_id = p.ingredient_id
            INNER JOIN product_amounts pa ON pa.product_id = p.id
            INNER JOIN ingredients i ON p.ingredient_id = i.id
            INNER JOIN recipe_ingredients ri ON i.id = ri.ingredient_id
            INNER JOIN measures mri ON ri.measure_id = mri.id
            WHERE recipe_id = :recipe_id;
        ';

        // step 5: prepare the bound parameters.
        $parameters = ["recipe_id" => [$recipe_id, true]];

        // step 6: execute the query & get the total calories value.
        $total_calories = $this->crud->selectOne($get_calories_query, $parameters)['total_calories'];

        // step 7: drop the temporary table.
        $drop_product_amounts_table = 'DROP TEMPORARY TABLE product_amounts;';
        $this->crud->doDelete($drop_product_amounts_table);

        return $total_calories;
    }
}
