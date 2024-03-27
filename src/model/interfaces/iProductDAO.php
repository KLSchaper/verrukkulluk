<?php

namespace vrklk\model\interfaces;

interface iProductDAO
{
    public function getIngredientProduct(
        int $ingredient_id,
        float $quantity,
        string $select_on = 'price'
    ): array;
    public function getProductById(int $product_id): array;
}
