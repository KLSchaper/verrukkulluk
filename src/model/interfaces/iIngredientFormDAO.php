<?php

namespace vrklk\model\interfaces;

interface iIngredientFormDAO
{
    public function getIngredientList(): array;
    public function getMeasures(int $ingredient_id): array;
}
