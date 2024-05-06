<?php

namespace vrklk\model\interfaces;

interface iRecipeDAO
{
    public function getHomeRecipes(
        int $amount,
        int $page_number
    ): array|false;
    public function getTotalHomeRecipes() : int|false;

    public function getFavoriteRecipes(
        int $amount,
        int $page_number,
        int $user_id
    ): array|false;
    public function getTotalFavoriteRecipes(int $user_id) : int|false;

    public function getSearchRecipes(
        int $amount,
        int $page_number,
        string $search_query
    ): array|false;
    public function getTotalSearchRecipes(string $search_query) : int|false;
    
    public function getRecipeIngredients(int $recipe_id): array|false;
    public function getRecipeDetails(int $recipe_id): array|false;
    public function getRecipeTitle(int $recipe_id): array|false;
}
