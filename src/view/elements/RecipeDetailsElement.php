<?php

namespace vrklk\view\elements;

class RecipeDetailsElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
    // Standard Data

    // Variable Data

    private array $recipe_data;
    private bool $is_favorite;

    public function __construct($recipe_id, $user_id)
    {
        // get recipe details from RecipeDAO
        // get whether it's a favorite for this user form FavoritesDAO

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
