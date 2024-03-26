<?php
namespace vrklk\model\recipe;

class PrepStepsTabDAO implements \vrklk\model\interfaces\iRecipeTabDAO
{
    public function getTabName() : string
    {
        return 'Opmerkingen';
    }
    
    public function getTabContent(int $recipe_id) : array
    {
        // retrieve the relevant content for this tab from DB
        return [];
    }
}