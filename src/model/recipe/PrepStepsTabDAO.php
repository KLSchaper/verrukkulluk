<?php

namespace vrklk\model\recipe;

class PrepStepsTabDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iRecipeTabDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getTabName(): string
    {
        return 'prep_steps';
    }

    public function getTabContent(int $recipe_id): array
    {
        $prep_steps = $this->crud->selectMore(
            "SELECT number, descr"
                . " FROM prep_steps"
                . " WHERE recipe_id = :recipe_id"
                . " ORDER BY number ASC",
            [
                'recipe_id' => [$recipe_id, true],
            ],
        );
        // convert false to empty array in case query execution failed
        return $prep_steps ? $prep_steps : [];
    }
}
