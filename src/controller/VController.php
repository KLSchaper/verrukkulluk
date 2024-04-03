<?php

namespace vrklk\controller;

class VController extends \vrklk\base\controller\Controller
{
    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function validateGet(): void
    {
        switch ($this->request['page']) {
            // needs to be extended
        }
    }

    protected function validatePost(): void
    {
        switch ($this->request['page']) {
            // needs to be extended
        }
    }

    protected function showResponse(): void
    {
        switch ($this->response['page']) {
            case 'site_test':
                $page = new \vrklk\view\VPage('Site');
                break;
            case 'agenda_test':
                $page = new \vrklk\view\VPage('Agenda');
                break;
            case 'favorite_test':
                $page = new \vrklk\view\VPage('Favorite');
                break;
            case 'recipeform_test':
                $page = new \vrklk\view\VPage('RecipeForm');
                break;
            case 'measureform_test':
                $page = new \vrklk\view\VPage('MeasureForm');
                break;
            case 'ingredientform_test':
                $page = new \vrklk\view\VPage('IngredientForm');
                break;
            case 'detailtabs_test':
                $page = new \vrklk\view\VPage('DetailTabs');
                break;
            case 'product_test':
                $page = new \vrklk\view\VPage('Product');
                break;
            case 'recipe_test':
                $page = new \vrklk\view\VPage('Recipe');
                break;
            case 'page_test':
                $page = new \vrklk\view\VPage('Page');
                break;
            default:
                $page = new \vrklk\view\VPage('404');
        }
        $page->show();
    }

    //=========================================================================
    // PRIVATE
    //=========================================================================
    private function getKeyValue(
        array $arr,
        string $key,
        mixed $default = false
    ): mixed {
        return (isset($arr[$key]) ? $arr[$key] : $default);
    }
}
