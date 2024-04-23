<?php

namespace vrklk\view\elements;

class RecipeDetailsElement extends \vrklk\base\view\BaseElement
{
    private int $recipe_id;
    private array $recipe_details;
    private bool $is_favorite;
    private string $ingredients_tab_title;
    private string $prep_steps_tab_title;
    private string $comments_tab_title;
    private array $ingredients_tab_content;
    private array $prep_steps_tab_content;
    private array $comments_tab_content;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct(int $recipe_id, int $user_id)
    {
        $this->recipe_id = $recipe_id;
        $this->recipe_details = \ManKind\ModelManager::getRecipeDAO()->getRecipeDetails($recipe_id);
        $this->is_favorite = \ManKind\ModelManager::getFavoritesDAO()->checkFavorite($recipe_id, $user_id);

        $this->ingredients_tab_title = \ManKind\ModelManager::getIngredientsTabDAO()->getTabName(); //TODO add display lookup to SiteDAO and translate to that or something idk
        $this->prep_steps_tab_title = \ManKind\ModelManager::getPrepStepsTabDAO()->getTabName(); //TODO add display lookup to SiteDAO and translate to that or something idk
        $this->comments_tab_title = \ManKind\ModelManager::getCommentsTabDAO()->getTabName(); //TODO add display lookup to SiteDAO and translate to that or something idk
        $this->ingredients_tab_content = \ManKind\ModelManager::getIngredientsTabDAO()->getTabContent($recipe_id);
        $this->prep_steps_tab_content = \ManKind\ModelManager::getPrepStepsTabDAO()->getTabContent($recipe_id);
        $this->comments_tab_content = \ManKind\ModelManager::getCommentsTabDAO()->getTabContent($recipe_id);
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
        $add_link = \Config::LINKBASE_PAGE . 'add_to_list&recipe_id=' . $this->recipe_id;
        
        if ($this->is_favorite) {
            $heart = 'fa-solid';
        } else {
            $heart = 'fa-regular';
        }

        $ingredients_tab = $this->makeIngredientsTabContent($this->ingredients_tab_content);
        $prep_steps_tab = $this->makePrepStepsTabContent($this->prep_steps_tab_content);
        $comments_tab = $this->makeCommentsTabContent($this->comments_tab_content);

        echo <<<EOD
        <div id="detail-page">

            <!-- Detail block main -->
            <div class="detail-main row my-3 shadow">
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
                            <h1 class="green-lily text-truncate" id="recipe-title">{$this->recipe_details['title']}</h1>
                            <div class="d-flex align-items-center">
                                <div><h4 class="green-lily my-auto">Keuken: </h4></div>
                                <div><p class="my-auto ps-1">{$this->recipe_details['cuisine']}</p></div>
                            </div>
                        </div>
                        <div class="col-sm-4 d-flex flex-column">
                            <div>Rating: {$this->recipe_details['rating']}/10</div>
                            <div class="d-flex align-items-center mt-auto">
                                <div><h4 class="green-lily my-auto">Type: </h4></div>
                                <div><p class="my-auto ps-1">{$this->recipe_details['display']}</p></div>
                            </div>
                        </div>
                    </div>
                    <div class="py-2">
                        <p>{$this->recipe_details['descr']}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <!-- <button class="btn p-0" id="add-to-list"> -->
                        <a href="{$add_link}" class="btn p-0" id="add-to-list">
                            <h1 class="m-0"><span class="badge rounded-pill red-white-lily">Op Lijst</span></h1>
                        <!-- </button> -->
                        </a>
                        <div class="ms-auto">
                            <h2><i class="{$heart} fa-heart red me-4" id="favorite-heart"></i></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail tabs -->
            <div class="detail-tab my-3 shadow">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#ingredients">
                            <h3><span class="green-lily">{$this->ingredients_tab_title}</span></h3>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#prep_steps">
                            <h3><span class="green-lily">{$this->prep_steps_tab_title}</span></h3>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#comments">
                            <h3><span class="green-lily">{$this->comments_tab_title}</span></h3>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content overflow-auto" style="height: 400px">
                    <div class="tab-pane container active" id="ingredients">
                        <div class="row">{$ingredients_tab}</div>
                    </div>
                    <div class="tab-pane container fade" id="prep_steps">
                        <div class="row">{$prep_steps_tab}</div>
                    </div>
                    <div class="tab-pane container fade" id="comments">
                        <div class="row">{$comments_tab}</div>
                    </div>
                </div>
            </div>
        </div>
        EOD . PHP_EOL;
    }

    //=========================================================================
    // PRIVATE
    //=========================================================================
    private function makeIngredientsTabContent($ingredients): string {
        $tab_content = '';
        foreach($ingredients as $ingredient) {
            $name = ucfirst($ingredient['ingredient']);
            $tab_content .=
            <<<EOD
            <div class="col-sm-3">
                {$ingredient['img']}
            </div>
            <div class="col-sm-9">
                <h3 class="green-lily">{$name}</h3>
                <p>{$ingredient['blurb']}</p>
                <div class="d-flex align-items-center">
                    <div><h4 class="green-lily my-auto">Hoeveelheid: </h4></div>
                    <div><p class="my-auto ps-1">{$ingredient['quantity']} {$ingredient['measure']}</p></div>
                </div>
            </div>
            EOD . PHP_EOL;
        }
        return $tab_content;
    }

    private function makePrepStepsTabContent($prep_steps): string {
        $tab_content = '';
        foreach($prep_steps as $prep_step) {
            $tab_content .= 
            <<<EOD
            <div class="col-sm-2">
                <div class="m-auto ps-number">
                    <h1>{$prep_step['number']}</h1>
                </div>
            </div>
            <div class="col-sm-10">
                <p>{$prep_step['descr']}</p>
            </div>
            EOD . PHP_EOL;
        }
        return $tab_content;
    }

    private function makeCommentsTabContent($comments): string {
        $tab_content = '';
        foreach($comments as $comment) {
            $tab_content .= 
            <<<EOD
            <div class="col-sm-3">
                {$comment['img']}
            </div>
            <div class="col-sm-8">
                <h3 class="green-lily">{$comment['name']}</h3>
                <p>{$comment['text']}</p>
            </div>
            EOD . PHP_EOL;
        }
        return $tab_content;
    }
}
