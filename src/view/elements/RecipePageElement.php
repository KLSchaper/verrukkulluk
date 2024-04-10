<?php

namespace vrklk\view\elements;

class RecipePageElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
    // Standard Data:
        // people image
        // euro sign image
        // calories image
    // Variable Data:
        // recipe details per recipe
        // page title
        // page number

    private \vrklk\model\recipe\RecipeDAO $recipe_dao;
    private array $recipe_details;
    private int $page_number;

    public function __construct(
        array $recipe_id_array,
        int $page_number
    ) {
        $this->recipe_dao = \ManKind\ModelManager::getRecipeDAO();
        foreach ($recipe_id_array as $recipe_id) {
            $this->recipe_details[$recipe_id] = 
                $this->recipe_dao->getRecipeDetails($recipe_id);
            
            // just for testing a full page with only 2 recipes in mock data db
            $this->recipe_details[$recipe_id + count($recipe_id_array)] = 
                $this->recipe_dao->getRecipeDetails($recipe_id);
        }
        ksort($this->recipe_details);
    }

    public function show()
    {
        // h: page title
        echo <<<EOD
        <div class="d-flex flex-wrap recipe-page" id="recipe-page">
        EOD . PHP_EOL;
        foreach ($this->recipe_details as $recipe_id => $recipe_data) {
            // img: recipe image (recipe_data['img'])
            // div:
                // h: recipe name (recipe_data['title'])
                // div: recipe rating (recipe_data['rating'])
            // p: recipe blurb (recipe_data['blurb'])
            // div:
                // button: "smullen"
                // img: "people"
                // p: recipe people (recipe_data['people'])
                // img: "euro sign"
                // p: price (recipe_data['price'])
                // img: "calories image"
                // p: calories (recipe_data['calories'])
            echo <<<EOD
            <div class="card recipe-card m-3" id="recipe-card-{$recipe_id}">
                <img src="./assets/img/recipes/{$recipe_data['img']}" alt="{$recipe_data['title']}" class="img-fluid">
                <div class="card-header">
                    <h1 class="lily" style="color: var(--darker-green)">{$recipe_data['title']}</h1>
                </div>
                <div class="card-body">
                    <p>{$recipe_data['blurb']}</p>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-dark p-0">
                        <h1 class="m-0"><span class="badge rounded-pill red-white-lily">Smullen!</span></h1>
                    </button>
                </div>
            </div>
            EOD . PHP_EOL;
        }
        // div: page buttons
        echo <<<EOD
        </div>
        EOD . PHP_EOL;
    }
}
