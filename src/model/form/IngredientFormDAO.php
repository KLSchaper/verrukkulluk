<?php
namespace vrklk\model\form;

class IngredientFormDAO extends \vrklk\model\form\FormDAO implements
    \vrklk\model\interfaces\iIngredientFormDAO
{
    public function getIngredientList() : array
    {
        // retrieve all ingredients from DB
        return $this->crud->selectMore(
            "SELECT *" 
            ." FROM ingredients" 
            ." ORDER BY name ASC"
        );
    }
    public function getMeasures(int $ingredient_id) : array
    {
        // retrieve all measures applicable to ingredient_id from DB
        return $this->crud->selectMore(
            "SELECT name, unit, quantity" 
            ." FROM measures" 
            ." WHERE (ingredient_id IS NULL AND unit=(SELECT unit FROM ingredients WHERE id=:ingredient_id1))"
            ." OR ingredient_id=:ingredient_id2",
            [
                'ingredient_id1'=>[$ingredient_id, true],
                'ingredient_id2'=>[$ingredient_id, true],
            ],
        );
    }
}