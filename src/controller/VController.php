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
            case 'site_test':
            case 'agenda_test':
            case 'favorite_test':
            case 'recipeform_test':
            case 'measureform_test':
            case 'ingredientform_test':
            case 'detailtabs_test':
            case 'product_test':
            case 'recipe_test':
                $this->response['page'] = 'test';
                $this->response['title'] = 
                    \vrklk\model\site\TestDAO::getTestTitle($this->request['page']);
                $this->response['function_calls'] = 
                    \vrklk\model\site\TestDAO::getTestFunctions($this->request['page']);
                break;
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
            case 'test':
                $title = $this->response['title'];
                $main_element = new \vrklk\view\elements\DataElement(
                    $this->response['title'],
                    $this->response['function_calls'],
                );
                break;
            case 'form_test':
                $page = new \vrklk\view\VPage('TestForm');
                break;
            
            case 'page_test':
                $page = new \vrklk\view\VPage('Page');
                break;
            default:
                $page = new \vrklk\view\VPage('404');
        }
        $page = new \vrklk\view\VPage($title, $main_element);
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
