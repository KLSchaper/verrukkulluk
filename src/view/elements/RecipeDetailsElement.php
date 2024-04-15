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
        echo <<<EOD
        <div id="detail-page">
            <div class="detail-main row m-3">
                <div class="col-sm-5">
                    <img class="img-fluid" src="./assets/img/recipes/{$this->recipe_details['img']}" alt="{$this->recipe_details['title']}">
                </div>
                <div class="col-sm-7">
                    <div class="d-flex">
                        <div>
                            <i class="fa-solid fa-user-group red ms-2 me-1"></i>{$this->recipe_details['people']}
                        </div>
                        <div>
                            <i class="fa-solid fa-euro-sign red ms-2 me-1"></i>{$this->recipe_details['price']}
                        </div>
                        <div>
                            <i class="fa-solid fa-fire-flame-curved red ms-2 me-1"></i>{$this->recipe_details['calories']}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="green-lily text-truncate">{$this->recipe_details['title']}</h1>
                        </div>
                        <div class="col-sm-4">
                            Rating: {$this->recipe_details['rating']}/10
                        </div>
                    </div>
                </div>
        EOD . PHP_EOL;
        if ($this->is_favorite) {
                // button: filled-in heart symbol (removes favorite)
        } else {
                // button: empty heart symbol (makes favorite)
        }
        echo <<<EOD
            </div>
            <div class="detail-tab">
            </div>
        </div>
        EOD . PHP_EOL;
    }
}
