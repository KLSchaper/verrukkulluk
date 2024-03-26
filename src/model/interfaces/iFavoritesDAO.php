<?php
namespace vrklk\model\interfaces;

interface iFavoritesDAO
{
    public function checkFavorite(int $recipe_id, int $user_id) : bool;
}