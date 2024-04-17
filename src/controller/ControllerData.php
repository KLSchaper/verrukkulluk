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
        session_unset();
        session_destroy();
        session_start();
    }

    public static function getLoggedUser(): int
    {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    }

    public static function addRecipeToShoppingList(int $recipe_id): void
    {
        echo 'adding recipe ' . $recipe_id . ' to shopping list!'; // TODO replace with nice alert
        $ingredients = \ManKind\ModelManager::getRecipeDAO()->getRecipeIngredients($recipe_id);
        foreach ($ingredients as $ingredient_id => $quantity) {
            if (isset($_SESSION['shopping_list'][$ingredient_id])) {
                $_SESSION['shopping_list'][$ingredient_id] += $quantity;
            } else {
                $_SESSION['shopping_list'][$ingredient_id] = $quantity;
            }
        }
    }

    public static function getShoppingList(): array {
        return isset($_SESSION['shopping_list']) ? $_SESSION['shopping_list'] : [];
    }
}
