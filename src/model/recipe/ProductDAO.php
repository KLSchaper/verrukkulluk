<?php
namespace vrklk\model\recipe;

class ProductDAO implements \vrklk\model\interfaces\iProductDAO
{
    public function getIngredientProduct(
        int $ingredient_id,
        float $quantity,
        string $select_on = 'price'
    ) : array
    {
        // returns the product info best matching parameters from DB
        return [];
    }

    public function getProductById(int $product_id) : array
    {
        // returns the product info matching the product_id
        return [];
    }
}