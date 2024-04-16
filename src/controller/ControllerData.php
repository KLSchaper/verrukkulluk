<?php

namespace vrklk\controller;

abstract class ControllerData
{
    public static function logInUser(int $user_id): void
    {
        echo 'logging in user ' . $user_id; // TODO replace with nice alert
        $_SESSION['user_id'] = $user_id;
    }

    public static function logOutUser(int $user_id): void
    {
        echo 'logging out user ' . $user_id; // TODO replace with nice alert
        unset($_SESSION['user_id']);
        // could destroy whole session instead but idk if we want that
        // session_unset();
        // session_destroy();
        // session_start();
    }

    public static function getLoggedUser(): int
    {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    }

    public static function addRecipeToShoppingList(int $recipe_id): void
    {
        echo 'adding recipe ' . $recipe_id . ' to shopping list!';
    }
}
