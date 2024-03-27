<?php
namespace vrklk\model\form;

class RecipeFormDAO extends \vrklk\model\form\FormDAO implements
    \vrklk\model\interfaces\iRecipeFormDAO
{
    public function getCuisineList() : array
    {
        return $this->crud->selectMore(
            "SELECT c.id, c.name, c.parent_id, c.type, l.display AS display_type" 
            ." FROM cuisines AS c" 
            ." INNER JOIN lookup AS l ON (l.group = 'cuisine_types' AND c.type = l.value)"
            ." ORDER BY c.type ASC"
        );
    }

    public function getRecipeTypes() : array
    {
        $lookup_types = $this->crud->selectMore(
            "SELECT display" 
            ." FROM lookup AS l" 
            ." WHERE l.group = 'recipe_types'"
            ." ORDER BY id ASC"
        );
        foreach($lookup_types as $display_type)
        {
            $types[] = $display_type['display'];
        }
        return $types;
    }
}