<?php

namespace vrklk\view\elements;

class RecipePageElement extends BaseElement
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

    private BaseDAO $recipe_dao;
    private array $recipe_details;

    public function __construct(array $recipe_id_array, int $page_number, string $page_title)
    {
        //initialize DAOs required:
        // -- RecipeDAO

        $this->recipe_details = [];
        foreach ($recipe_id_array as $recipe_id) {
            $this->recipe_details[] = $this->recipe_dao->getRecipeDetails($recipe_id);
        }
    }

    public function show()
    {
        // h: page title

        foreach ($this->recipe_details as $recipe_data) {
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