<?php

namespace vrklk\model\interfaces;

interface iRecipeTabDAO
{
    public function getTabName(): string;
    public function getTabContent(int $recipe_id): array|false;
}
