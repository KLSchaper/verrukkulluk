<?php

namespace vrklk\model\recipe;

class ProductDAO extends \vrklk\base\model\BaseDAO implements \vrklk\model\interfaces\iProductDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getIngredientProduct(
        int $ingredient_id,
        float $quantity,
        string $select_on = 'price'
    ): array|false {
        // returns the product info best matching parameters from DB

        // fetch product list of the ingredient ID into $product_list, with standard_quantity instead of the table's quantity
        // information needed; id, quantity (multiplied by measure quantity), price
        $product_list_query = '
            SELECT p.id AS id, (p.quantity * m.quantity) AS standard_quantity, price
            FROM products p
            INNER JOIN measures m ON p.measure_id = m.id
            WHERE p.ingredient_id = :ingredient_id;
        ';
        $product_list_parameters = ['ingredient_id' => [$ingredient_id, true]];
        $product_list = $this->crud->selectMore($product_list_query, $product_list_parameters);

        if ($product_list) {
            return $this->getOptimalProducts($quantity, $product_list, INF);
        } else {
            // could be empty array (no results) or false (query failed)
            return $product_list;
        }
    }

    public function getProductById(int $product_id): array|false
    {
        // returns the product info matching the product_id
        $get_product_query = '
            SELECT p.name AS name, img, blurb, p.quantity AS quantity, price, calories, i.name AS ingredient, m.name AS measure
            FROM products p
            INNER JOIN measures m ON p.measure_id = m.id
            INNER JOIN ingredients i ON p.ingredient_id = i.id
            WHERE p.id = :product_id;
        ';
        $get_product_parameters = ['product_id' => [$product_id, true]];
        return $this->crud->selectOne($get_product_query, $get_product_parameters);
    }


    //private functions
    protected function getOptimalProducts(float $required_quantity, array $product_list, float $max_quantity): array
    {
        $lowest_option_price = INF;
        $lowest_option_products = [];
        foreach ($product_list as $product) {
            if ($product['standard_quantity'] <= $max_quantity) {
                $option_products = [];
                if ($product['standard_quantity'] >= $required_quantity - 1E-10) {
                    $option_price = $product['price'];
                    $option_products = [$product['id'] => 1];
                } else {
                    $remainder = $required_quantity - $product['standard_quantity'];
                    $option_price = $product['price'];
                    if ($option_price < $lowest_option_price) {
                        $price_products_array = $this->getOptimalProducts($remainder, $product_list, $product['standard_quantity']);
                        $option_price += $price_products_array['price'];
                        $option_products = $price_products_array['products'];
                        if (array_key_exists(strval($product['id']), $option_products)) {
                            $option_products[strval($product['id'])] += 1;
                        } else {
                            $option_products[strval($product['id'])] = 1;
                        }
                    }
                }
                if ($option_price < $lowest_option_price) {
                    $lowest_option_price = $option_price;
                    $lowest_option_products = $option_products;
                }
            }
        }
        return ['price' => $lowest_option_price, 'products' => $lowest_option_products];
    }
}
