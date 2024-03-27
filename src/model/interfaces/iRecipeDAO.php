<?php

namespace vrklk\model\interfaces;

interface iRecipeDAO
{
    public function getHomeRecipes(
        int $amount,
        int $page_number
    ): array;
    public function getFavoriteRecipes(
        int $amount,
        int $page_number,
        int $user_id
    ): array;
    public function getSearchRecipes(
        int $amount,
        int $page_number,
        string $query
    ): array;
    public function getRecipeDetails(int $recipe_id): array;
}
