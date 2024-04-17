<?php

namespace vrklk\model\user;

class AddRecipeDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iAddMeasure,
    \vrklk\model\interfaces\iAddRecipe
{
    /*  EXPECTED VALUES:
        
        $recipe_values = [
            'name' => 'stamppot',
            'img' => 'stamppot.webp',
            'blurb' => 'lekker',
            ...etc
        ]

        $ingredient_values = [
            0 => [
                'ingredient_id' => 1,
                'quantity' => 3.14,
                'measure_id' => 1
            ],
            1 => [
                'ingredient_id' => 1,
                'quantity' => 3.14,
                'measure_id' => 1
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
        return 0;
    }

    public function addMeasure(
        int $ingredient_id,
        string $name,
        string $category,
        float $quantity
    ): int|false {
        return 0; // TODO implement function
    }

    //=========================================================================
    // PRIVATE
    //=========================================================================
    private function addRecipe(
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

    private function storeRecipeIngredient(
        int $recipe_id,
        int $ingredient_id,
        float $quantity,
        int $measure_id
    ): bool {
        return false; // TODO implement function
    }

    private function storeRecipeStep(
        int $recipe_id,
        int $number,
        string $descr
    ): bool {
        return false; // TODO implement function
    }
}
