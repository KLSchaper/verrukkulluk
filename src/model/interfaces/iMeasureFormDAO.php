<?php

namespace vrklk\model\interfaces;

interface iMeasureFormDAO
{
    public function getUnit(int $ingredient_id): string;
}
