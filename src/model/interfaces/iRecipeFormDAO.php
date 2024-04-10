<?php

namespace vrklk\model\interfaces;

interface iRecipeFormDAO
{
    public function getCuisineList(): array|false;
    public function getRecipeTypes(): array|false;
}
