<?php

namespace vrklk\view\elements;

class RecipeDetailsElement extends \vrklk\base\view\BaseElement
{
    private array $recipe_details;
    private bool $is_favorite;

    public function __construct(int $recipe_id, int $user_id)
    {
        $this->recipe_details = \ManKind\ModelManager::getRecipeDAO()->getRecipeDetails($recipe_id);
        $this->is_favorite = \ManKind\ModelManager::getFavoritesDAO()->checkFavorite($recipe_id, $user_id);
    }

    public function show()
    {
        //div: left
            //img: large cropped recipe image
        //div: right
            //div:
                // img: people icon
                // p: amount of people (from recipe data)
                // img: euro icon
                // p: price (from recipe data)
                // img: calories symbol
                // p: calories (from recipe data)
            //div:
                // h: recipe name (from recipe data)
                // element: rating (value from recipe data)
            //div:
                // p: "keuken"
                // p: cuisine (from recipe data)
                // p: "type"
                // p: type (from recipe data)
            //div:
                // p: recipe description (from recipe data)
            //div:
                // button: "op lijst" (put ingredients in shopping list)
        
        if ($this->is_favorite) {
                // button: filled-in heart symbol (removes favorite)
        } else {
                // button: empty heart symbol (makes favorite)
        }
    }
}
