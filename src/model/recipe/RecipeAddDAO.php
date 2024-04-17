<?php

namespace vrklk\model\user;

class RecipeAddDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iAddMeasure,
    \vrklk\model\interfaces\iAddRecipe
{
    public function addMeasure(
        int $ingredient_id,
        string $name,
        string $category,
        float $quantity
    ): int|false {
        return 0; // TODO implement function
    }

    public function storeRecipe(
        string $name,
        string $img,
        string $blurb,
        int $people,
        int $cuisine_id,
        string $type,
        string $descr
    ): int|false {
        return 0; // TODO implement function
    }

    public function storeRecipeIngredient(
        int $recipe_id,
        int $ingredient_id,
        float $quantity,
        int $measure_id
    ): bool {
        return false; // TODO implement function
    }

    public function storeRecipeStep(
        int $recipe_id,
        int $number,
        string $descr
    ): bool {
        return false; // TODO implement function
    }
}
