<?php

namespace vrklk\model\user;

use PDOException;

class AddRecipeDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iAddMeasure,
    \vrklk\model\interfaces\iAddRecipe
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    /*  EXPECTED VALUES:
        
        $recipe_values = [
            'name' => 'stamppot',
            'img' => 'stamppot.webp',
            'blurb' => 'lekker',
            'people' => 4,
            'cuisine_id' => 6,
            'type' => 'meat',
            'descr' => 'een winterse klassieker',
            'user_id' => 1
        ]

        $ingredient_values = [
            0 => [
                'ingredient_id' => 9,
                'quantity' => 3.14,
                'measure_id' => 2
            ],
            1 => [
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
        } catch (PDOException $e) {
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
        string $descr,
        int $user_id,
    ): int|false {
        return $this->crud->doInsert(
            "INSERT INTO recipes (name, img, blurb, people, cuisine_id, type, descr, user_id)"
                . " VALUES (:name, :img, :blurb, :people, :cuisine_id, :type, :descr, :user_id)",
            [
                'name' => [$name, false],
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
            "INSERT INTO recipe_ingredients (recipe_id, number, descr)"
                . " VALUES (:recipe_id, :number, :descr)",
            [
                'recipe_id' => [$recipe_id, true],
                'number' => [$number, true],
                'descr' => [$descr, false],
            ]
        );
    }
}
