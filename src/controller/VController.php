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
            case 'log_out':
                $this->response['page'] = 'home';
                \vrklk\controller\ControllerData::logOutUser($this->getRequestVar('user_id', false, 0, true));
                // no break, falls through
            case 'home':
                $this->response['title'] = 'Home';
                $this->response['page_number'] = $this->getRequestVar('page_number', false, 1, true);
                break;
            case 'favorites':
                $this->response['title'] = 'Mijn Favorieten';
                $this->response['page_number'] = $this->getRequestVar('page_number', false, 1, true);
                break;
            case 'add_to_list';
                $this->response['page'] = 'details';
                \vrklk\controller\ControllerData::addRecipeToShoppingList($this->getRequestVar('recipe_id', false, 0, true));
                // no break, falls through
            case 'details':
                $this->response['title'] = 'Recept Details';
                $this->response['recipe_id'] = $this->getRequestVar('recipe_id', false, 0, true);
                break;
            case 'shopping_list';
                $this->response['title'] = 'Mijn Boodschappenlijst';
                $this->response['shopping_list'] = \vrklk\controller\ControllerData::getShoppingList();
                $this->response['user_adaptations'] = \vrklk\controller\ControllerData::getUserAdaptations();
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
        $user_id = \vrklk\controller\ControllerData::getLoggedUser();
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
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getHomeRecipes(
                    4,
                    $this->response['page_number'],
                );
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalHomeRecipes() / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $this->response['page_number'],
                    total_pages: $total_pages,
                    page: $this->response['page'],
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
            case 'favorites':
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getFavoriteRecipes(
                    4,
                    $this->response['page_number'],
                    $user_id,
                );
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalFavoriteRecipes($user_id) / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $this->response['page_number'],
                    total_pages: $total_pages,
                    page: $this->response['page'],
                );
                break;
            case 'search':
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getSearchRecipes(
                    4,
                    $this->response['page_number'],
                    $this->$search_query,
                );
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalSearchRecipes($this->$search_query) / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $this->response['page_number'],
                    total_pages: $total_pages,
                    page: $this->response['page'],
                );
                break;
            case 'details':
                $main_element = new \vrklk\view\elements\RecipeDetailsElement($this->response['recipe_id'], $user_id);
                break;
            case 'shopping_list':
                $main_element = new \vrklk\view\elements\ShoppingListElement(
                    $this->response['shopping_list'],
                    $this->response['user_adaptations'],
                );
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
