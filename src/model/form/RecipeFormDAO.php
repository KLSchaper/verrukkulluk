<?php
namespace vrklk\model\form;

class RecipeFormDAO extends \vrklk\model\form\FormDAO implements
    \vrklk\model\interfaces\iRecipeFormDAO
{
    public function getCuisineList() : array
    {
        // retrieve all cuisines from DB
        return $this->crud->selectMore(
            "SELECT *" 
            ." FROM cuisines" 
            ." ORDER BY type ASC"
        );
    }

    public function getRecipeTypes() : array
    {
        // retrieve all recipe types from DB
        var_dump($this->crud->selectMore(
            "SELECT COLUMNS" 
            ." FROM `recipes`" 
            ." LIKE 'type'"
        ));
        // can it be done with SQL or do we need to hardcode it?
        return [
            'Vlees & Vis',
            'Vlees',
            'Vis',
            'Vegetarisch',
            'Vegan',
        ];
    }
}