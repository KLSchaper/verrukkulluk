<?php

namespace vrklk\model\interfaces;

interface iAddRecipe
{
    public function storeRecipe(
        string $name,
        string $img,
        string $blurb,
        int $people,
        int $cuisine_id,
        string $type,
        string $descr
    ): int | false;
    public function storeRecipeIngredient(
        int $recipe_id,
        int $ingredient_id,
        float $quantity,
        int $measure_id
    ): bool;
    public function storeRecipeStep(
        int $recipe_id,
        int $number,
        string $descr
    ): bool;
}
