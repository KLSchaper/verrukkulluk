<?php

namespace vrklk\model\interfaces;

interface iRecipeDAO
{
    public function getHomeRecipes(
        int $amount,
        int $page_number
    ): array|false;
    public function getFavoriteRecipes(
        int $amount,
        int $page_number,
        int $user_id
    ): array|false;
    public function getSearchRecipes(
        int $amount,
        int $page_number,
        string $searchQuery
    ): array|false;
    public function getRecipeDetails(int $recipe_id): array|false;
}
