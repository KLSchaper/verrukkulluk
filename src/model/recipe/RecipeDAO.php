<?php

namespace vrklk\model\recipe;

class RecipeDAO implements \vrklk\model\interfaces\iRecipeDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getHomeRecipes(int $amount, int $page_number): array
    {
        // retrieves amount of recipe_id's, offset by page_number, from DB
        return [];
    }

    public function getFavoriteRecipes(
        int $amount,
        int $page_number,
        int $user_id
    ): array {
        // retrieves amount of recipe_id's, offset by page_number, from DB
        // where recipe_id is a favorite for user_id
        return [];
    }

    public function getSearchRecipes(
        int $amount,
        int $page_number,
        string $query
    ): array {
        // retrieves amount of recipe_id's, offset by page_number, from DB
        // where recipe_id is a valid match for query
        return [];
    }

    public function getRecipeDetails(int $recipe_id): array
    {
        // includes rating, price, calories, cuisine name, and author name
        return [];
    }
}
