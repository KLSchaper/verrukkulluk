<?php
namespace vrklk\model\interfaces;

interface iAddMeasure
{
    public function addMeasure(
        int $ingredient_id,
        string $name,
        string $category,
        float $quantity
    ) : int | false;
}