<?php

namespace vrklk\model\recipe;

class AddRecipeDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iAddMeasure,
    \vrklk\model\interfaces\iAddRecipe
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    /*  EXPECTED VALUES:
        
        $recipe_values = [
            'title' => 'stamppot',
            'img' => 'stamppot.webp',
            'blurb' => 'lekker',
            'people' => 4,
            'cuisine_id' => 6,
            'type' => 'meat',
            'descr' => 'een winterse klassieker',
            'user_id' => 1
        ]

        $ingredient_values = [
            [
                'ingredient_id' => 9,
                'quantity' => 3.14,
                'measure_id' => 2
            ],
            [
                'ingredient_id' => 5,
                'quantity' => 2.71,
                'measure_id' => 7
            ],
            ...etc
        ]

        $prep_step_values = [
            1 => 'doe iets',
            2 => 'doe nog iets',
            3 => 'wacht even',
            4 => 'eet smakelijk!'
        ]
    */
    public function storeNewRecipe(
        array $recipe_values,
        array $ingredient_values,
        array $prep_step_values
    ): int|false {
        try {
            $this->crud->beginTransaction();
            $recipe_id = $this->addRecipe(...$recipe_values);
            foreach ($ingredient_values as $ingredient) {
                $this->addRecipeIngredient($recipe_id, ...$ingredient);
            }
            foreach ($prep_step_values as $step_number => $step_descr) {
                $this->addRecipeStep($recipe_id, $step_number, $step_descr);
            }
            $this->crud->commit();
            return $recipe_id;
        } catch (\PDOException $e) {
            $this->crud->rollBack();
            \ManKind\tools\dev\Logger::_error($e);
            return false;
        }
    }

    public function addMeasure(
        int $ingredient_id,
        string $name,
        string $unit,
        float $quantity
    ): int|false {
        return $this->crud->doInsert(
            "INSERT INTO measures (ingredient_id, name, unit, quantity)"
                . " VALUES (:ingredient_id, :name, :unit, :quantity)",
            [
                'ingredient_id' => [$ingredient_id, true],
                'name' => [$name, false],
                'unit' => [$unit, false],
                'quantity' => [$quantity, true],
            ]
        );
    }

    // these measures have been added for the validation
    public function checkRecipeName (string $recipe_name): bool
    {
        $check_recipe_name_query = '
            SELECT id
            FROM recipes
            WHERE title = :title;
        ';
        $parameters = ['title' => [$recipe_name, false]];
        return boolval($this->crud->selectOne($check_recipe_name_query, $parameters));
    }

    public function checkIngredientMeasure (string $ingredient_name, string $measure_name): bool
    {
        $general_measure_query = '
            SELECT ingredient_id
            FROM measures
            WHERE name = :measure_name;
        ';
        $general_measure_parameters = ['measure_name' => [$measure_name, false]];
        $general_measure_data = $this->crud->selectOne($general_measure_query, $general_measure_parameters);

        if (is_null($general_measure_data['ingredient_id'])) {
            return true;
        }

        $combined_data_query = '
            SELECT i.unit, m.unit
            FROM ingredients i
            INNER JOIN measures m ON m.ingredient_id = i.id
            WHERE i.name = :ingredient_name AND m.name = :measure_name;
        ';
        $combined_parameters = ['ingredient_name' => [$ingredient_name, false], 'measure_name' => [$measure_name, false]];
        $combined_data = $this->crud->selectOne($combined_data_query, $combined_parameters);

        if ($combined_data) {
            if ($combined_data['i.unit'] == $combined_data['m.unit']) {
                return true;
            }
        }

        return false;
    }

    public function checkMeasureName (string $measure_name): bool
    {
        $check_measure_name_query = '
            SELECT id
            FROM measures
            WHERE name = :name;
        ';
        $parameters = ['name' => [$measure_name, false]];
        return boolval($this->crud->selectOne($check_measure_name_query, $parameters));
    }

    public function getCuisineByName (string $cuisine_name): int
    {
        $get_cuisine_query = '
            SELECT id
            FROM cuisines
            WHERE name = :name
        ';
        $parameters = ['name'=> [$cuisine_name, false]];
        return $this->crud->selectOne($get_cuisine_query, $parameters)['id'];
    }

    public function getTypeByName (string $type_name): int
    {
        $get_type_query = '
            SELECT id
            FROM lookup l
            WHERE value = :value
        ';
        $parameters = ['value'=> [$type_name, false]];
        return $this->crud->selectOne($get_type_query, $parameters)['id'];
    }

    public function getIngredientByName (string $ingredient_name): int
    {
        $get_ingredient_query = '
            SELECT id
            FROM ingredients
            WHERE name = :name
        ';
        $parameters = ['name'=> [$ingredient_name, false]];
        return $this->crud->selectOne($get_ingredient_query, $parameters)['id'];
    }

    public function getMeasureByName (string $measure_name): int
    {
        $get_measure_query = '
            SELECT id
            FROM measures
            WHERE name = :name
        ';
        $parameters = ['name'=> [$measure_name, false]];
        return $this->crud->selectOne($get_measure_query, $parameters)['id'];
    }

    // for testing purposes only
    public function testRecipe(
        array $recipe_values,
        array $ingredient_values,
        array $prep_step_values
    )
    {
        var_dump($recipe_values);
        echo'<br><br>';
        var_dump($ingredient_values);
        echo'<br><br>';
        var_dump($prep_step_values);
    }


    //=========================================================================
    // PRIVATE
    //=========================================================================
    private function addRecipe(
        string $title,
        string $img,
        string $blurb,
        int $people,
        int $cuisine_id,
        string $type,
        string $descr,
        int $user_id,
    ): int|false {
        return $this->crud->doInsert(
            "INSERT INTO recipes (title, img, blurb, people, cuisine_id, type, descr, user_id)"
                . " VALUES (:title, :img, :blurb, :people, :cuisine_id, :type, :descr, :user_id)",
            [
                'title' => [$title, false],
                'img' => [$img, false],
                'blurb' => [$blurb, false],
                'people' => [$people, true],
                'cuisine_id' => [$cuisine_id, true],
                'type' => [$type, false],
                'descr' => [$descr, false],
                'user_id' => [$user_id, true],
            ]
        );
    }

    private function addRecipeIngredient(
        int $recipe_id,
        int $ingredient_id,
        float $quantity,
        int $measure_id
    ): bool {
        return $this->crud->doInsert(
            "INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity, measure_id)"
                . " VALUES (:recipe_id, :ingredient_id, :quantity, :measure_id)",
            [
                'recipe_id' => [$recipe_id, true],
                'ingredient_id' => [$ingredient_id, true],
                'quantity' => [$quantity, true],
                'measure_id' => [$measure_id, true],
            ]
        );
    }

    private function addRecipeStep(
        int $recipe_id,
        int $number,
        string $descr
    ): bool {
        return $this->crud->doInsert(
            "INSERT INTO prep_steps (recipe_id, number, descr)"
                . " VALUES (:recipe_id, :number, :descr)",
            [
                'recipe_id' => [$recipe_id, true],
                'number' => [$number, true],
                'descr' => [$descr, false],
            ]
        );
    }
}
