<?php

namespace vrklk\model\interfaces;

interface iRecipeFormDAO
{
    public function getCuisineList(): array;
    public function getRecipeTypes(): array;
}
