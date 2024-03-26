<?php
namespace vrklk\model\recipe;

class PrepStepsTabDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iRecipeTabDAO
{
    public function getTabName() : string
    {
        return 'Bereidingswijze';
    }
    
    public function getTabContent(int $recipe_id) : array
    {
        return $this->crud->selectMore(
            "SELECT number, descr"
            ." FROM prep_steps"
            ." WHERE recipe_id = :recipe_id"
            ." ORDER BY number ASC",
            [
                'recipe_id' => [$recipe_id, true],
            ],
        );
    }
}