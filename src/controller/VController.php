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
                $this->response['page'] = 'dao_test';
                $this->response['title'] = \vrklk\model\site\TestDAO::getTestTitle($this->request['page']);
                $this->response['function_calls'] = \vrklk\model\site\TestDAO::getTestFunctions($this->request['page']);
                break;
            case 'form_test':
                $this->response['title'] = 'TestForm';
                break;
            case 'home':
                $this->response['title'] = 'Home';
                break;
            default:
                $this->response['title'] = '404';
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
            case 'dao_test':
                $main_element = new \vrklk\view\elements\DataElement(
                    $this->response['title'],
                    $this->response['function_calls'],
                );
                break;
            case 'form_test':
                $main_element = new \vrklk\view\elements\FormElement(
                    6,
                    [
                        'form_values' => [], 
                        'form_errors' => []
                    ]
                );
                break;
            
            case 'home':
                $page_number = 1; // TODO read from url request
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getHomeRecipes(4, $page_number);
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalHomeRecipes() / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $page_number,
                    total_pages: $total_pages,
                );
                break;

            case 'register':
                // test only
                $this->response['controller_form_data'] = ['form_values' => [], 'form_errors' => []];
                //
                $main_element = new \vrklk\view\elements\FormPageElement('Registreren', 6, $this->response['controller_form_data']);
                break;
            case 'add_recipe':
                // test only
                $this->response['controller_form_data'] = ['form_values' => [], 'form_errors' => []];
                //
                $main_element = new \vrklk\view\elements\FormPageElement('Recept Toevoegen', 4, $this->response['controller_form_data']);
                break;

            default:
                $main_element = new \vrklk\view\elements\TextElement(
                    'De gevraagde pagina is niet gevonden',
                    '404',
                );
        }
        $user_id = 0; // TODO read from session
        $page = new \vrklk\view\VPage($this->response['title'], $main_element, $user_id);
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
