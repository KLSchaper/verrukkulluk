<?php

namespace vrklk\model\interfaces;

interface iAddRecipe
{
    public function storeNewRecipe(
        array $recipe_values,
        array $ingredient_values,
        array $prep_step_values
    ): int | false;
}
