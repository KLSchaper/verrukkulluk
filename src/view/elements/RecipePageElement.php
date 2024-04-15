<?php

namespace vrklk\view\elements;

class RecipePageElement extends \vrklk\base\view\BaseElement
{
    private \vrklk\model\recipe\RecipeDAO $recipe_dao;
    private array $recipe_details;
    private int $page_number;
    private int $total_pages;

    public function __construct(
        array $recipe_id_array,
        int $page_number,
        int $total_pages
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
        // end of testing code
        $this->page_number = $page_number;
        $this->total_pages = $total_pages;
    }

    public function show()
    {
        echo <<<EOD
        <div class="d-flex flex-wrap container-fluid" id="recipe-page">
        EOD . PHP_EOL;
        foreach ($this->recipe_details as $recipe_id => $recipe_data) {
            echo <<<EOD
            <div class="card recipe-card m-3" id="recipe-card-{$recipe_id}">
                <img class="card-img-top" src="./assets/img/recipes/{$recipe_data['img']}" alt="{$recipe_data['title']}">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="card-title green-lily text-truncate">{$recipe_data['title']}</h1>
                        </div>
                        <div class="col-sm-4">
                            Rating: {$recipe_data['rating']}/10
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text text-truncate-3">{$recipe_data['blurb']}</p>
                </div>
                <div class="card-footer d-flex align-items-center">
                    <button type="button" class="btn btn-card p-0">
                        <h1 class="m-0"><span class="badge rounded-pill red-white-lily">Smullen!</span></h1>
                    </button>
                    <div class="ms-auto">
                        <i class="fa-solid fa-user-group red ms-2 me-1"></i>{$recipe_data['people']}
                    </div>
                    <div>
                        <i class="fa-solid fa-euro-sign red ms-2 me-1"></i>{$recipe_data['price']}
                    </div>
                    <div>
                        <i class="fa-solid fa-fire-flame-curved red ms-2 me-1"></i>{$recipe_data['calories']}
                    </div>
                </div>
            </div>
            EOD . PHP_EOL;
        }
        echo <<<EOD
        </div>
        <div class="d-flex justify-content-center">
            <ul class="pagination pagination-sm">
        EOD . PHP_EOL;
        for ($i = 1; $i <= $this->total_pages; $i++) {
            $active = '';
            if ($i === $this->page_number)
                $active = ' rp-active';
            echo <<<EOD
                    <li class="page-item{$active}"><a class="rp-page-link" href="#">{$i}</a></li>
            EOD . PHP_EOL;
        }
        echo <<<EOD
            </ul>
        </div>
        EOD . PHP_EOL;
    }
}
