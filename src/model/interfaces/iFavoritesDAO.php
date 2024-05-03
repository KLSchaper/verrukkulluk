<?php

namespace vrklk\model\interfaces;

interface iFavoritesDAO
{
    public function checkFavorite(int $recipe_id, int $user_id): bool;
    public function addFavorite(int $recipe_id, int $user_id): int|false;
    public function removeFavorite(int $recipe_id, int $user_id): int|false;
}
