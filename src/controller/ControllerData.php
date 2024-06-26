<?php

namespace vrklk\controller;

class ControllerData
{
    public static function logInUser(int $user_id): void
    {
        $_SESSION['user_id'] = $user_id;
    }

    public static function logOutUser(): void
    {
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

    public static function addUserAdaptation(int $product_id, int $amount): void
    {
        if (isset($_SESSION['user_adaptations'][$product_id])) {
            $_SESSION['user_adaptations'][$product_id] += $amount;
        } else {
            $_SESSION['user_adaptations'][$product_id] = $amount;
        }
    }

    public static function getUserAdaptations(): array {
        return isset($_SESSION['user_adaptations']) ? $_SESSION['user_adaptations'] : [];
    }
}
