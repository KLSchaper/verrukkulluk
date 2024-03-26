<?php
namespace vrklk\controller;

class VController extends \vrklk\base\controller\Controller
{
    protected function validateGet(): void
    {
        switch ($this->request['page'])
        {
            // needs to be extended
        }
    }

    protected function validatePost(): void
    {
        switch ($this->request['page'])
        {
            // needs to be extended
        }
    }

    protected function showResponse(): void
    {
        switch ($this->response['page'])
        {
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
            default:
                $page = new \vrklk\view\VPage('404');
        }
        $page->show();
    }
//=============================================================================
// PRIVATE
//=============================================================================
    private function getKeyValue(
        array $arr,
        string $key,
        mixed $default=false
    ) : mixed 
    {
        return (isset($arr[$key]) ? $arr[$key] : $default);
    }
}