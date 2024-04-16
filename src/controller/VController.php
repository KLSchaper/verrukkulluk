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
                $this->response['page_number'] = $this->getRequestVar('page_number', false, 1, true);
                break;
            case 'favorites':
                $this->response['title'] = 'Mijn Favorieten';
                break;
            case 'details':
                $this->response['recipe_id'] = 1; // TODO read from URL request
                $this->response['title'] = 'Recept Details';
                break;
            case 'shopping_list';
                $this->response['title'] = 'Mijn Boodschappenlijst';
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
        $user_id = 1; // TODO read from session
        switch ($this->response['page']) {
            case 'dao_test':
                $main_element = new \vrklk\view\elements\DataElement(
                    $this->response['title'],
                    $this->response['function_calls'],
                );
                break;
            case 'form_test':
                $main_element = new \vrklk\view\elements\FormElement(
                    1,
                    [
                        'form_values' => [], 
                        'form_errors' => []
                    ]
                );
                break;
            
            case 'home':
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getHomeRecipes(4, $this->response['page_number']);
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalHomeRecipes() / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $this->response['page_number'],
                    total_pages: $total_pages,
                    page: $this->response['page'],
                );
                break;
            case 'favorites':
                $main_element = new \vrklk\view\elements\RecipePageElement([], 1, 1);
                break;
            case 'details':
                $main_element = new \vrklk\view\elements\RecipeDetailsElement(1, $user_id);
                break;
            case 'shopping_list':
                $main_element = new \vrklk\view\elements\ShoppingListElement([
                    10  => 10,
                    2   => 10,
                    13  => 10,
                    8   => 10,
                    12  => 10,
                ], 
                [
                    1   => 1,
                    3   => 1,
                    16  => 1,
                    17  => 1,
                    18  => -1,
                ]);
                break;
            default:
                $main_element = new \vrklk\view\elements\TextElement(
                    'De gevraagde pagina is niet gevonden',
                    '404',
                );
        }
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
