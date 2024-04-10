<?php

namespace vrklk\model\form;

class MeasureFormDAO extends \vrklk\model\form\FormDAO implements
    \vrklk\model\interfaces\iMeasureFormDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getUnit(int $ingredient_id): string|false
    {
        // retrieve the type of unit for ingredient_id from DB
        $ingredient = $this->crud->selectOne(
            "SELECT unit"
                . " FROM ingredients"
                . " WHERE id=:ingredient_id",
            [
                'ingredient_id' => [$ingredient_id, true],
            ],
        );
        return $ingredient ? $ingredient['unit'] : $ingredient;
    }
}
