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

    public function __construct(
        array $recipe_id_array,
        int $page_number,
        string $page_title
    ) {
        $this->recipe_dao = \ManKind\ModelManager::getRecipeDAO();
        $this->recipe_details = [];
        foreach ($recipe_id_array as $recipe_id) {
            $this->recipe_details[$recipe_id] = 
                $this->recipe_dao->getRecipeDetails($recipe_id);
        }
    }

    public function show()
    {
        // h: page title

        foreach ($this->recipe_details as $recipe_id => $recipe_data) {
            // img: recipe image (recipe_data['image'])
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
        }

        // div: page buttons
    }
}
