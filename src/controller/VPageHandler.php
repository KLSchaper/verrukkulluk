<?php

namespace vrklk\controller;

use \vrklk\base\controller\Request;

class VPageHandler extends \vrklk\base\controller\BasePageHandler
{
    protected array $controller_form_array;

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function _validateGet(): void
    {
        switch ($this->requested_page) {
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
                break;
            case 'log_out':
                $this->response['page'] = 'home';
                \vrklk\controller\ControllerData::logOutUser(Request::getRequestVar('user_id', 0, true));
                // no break, falls through
            case 'home':
                $this->response['page_number'] = Request::getRequestVar('page_number', 1, true);
                break;
            case 'favorites':
                $this->response['page_number'] = Request::getRequestVar('page_number', 1, true);
                break;
            case 'add_to_list';
                $this->response['page'] = 'details';
                \vrklk\controller\ControllerData::addRecipeToShoppingList(Request::getRequestVar('recipe_id', 0, true));
                // no break, falls through
            case 'details':
                $this->response['recipe_id'] = Request::getRequestVar('recipe_id', 0, true);
                break;
            case 'shopping_list';
                $this->response['shopping_list'] = \vrklk\controller\ControllerData::getShoppingList();
                $this->response['user_adaptations'] = \vrklk\controller\ControllerData::getUserAdaptations();
                break;
            case 'register':
                $this->controller_form_array = ['form_values' => [], 'form_errors' => []];
                break;
            case 'add_recipe':
                $this->controller_form_array = ['form_values' => [], 'form_errors' => []];
                break;
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid GET request: '
                    . $this->requested_page);
        }
    }

    protected function _validatePost(): void
    {
        switch ($this->requested_page) {
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid POST request: '
                    . $this->requested_page);
        }
    }

    protected function _showResponse(): void
    {
        $user_id = \vrklk\controller\ControllerData::getLoggedUser();
        switch ($this->response['page']) {
            case 'dao_test':
                $this->response['title'] = \vrklk\model\site\TestDAO::getTestTitle($this->requested_page);
                $main_element = new \vrklk\view\elements\DataElement(
                    $this->response['title'],
                    \vrklk\model\site\TestDAO::getTestFunctions($this->requested_page),
                );
                break;
            case 'form_test':
                $this->response['title'] = 'TestForm';
                $main_element = new \vrklk\view\elements\FormElement(
                    6,
                    [],
                    $this->response['page']
                );
                break;
            case 'home':
                $this->response['title'] = 'Home';
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
                $this->response['title'] = 'Registreren';  
                $main_element = new \vrklk\view\elements\FormPageElement('Registreren', 6, $this->controller_form_array, $this->response['page']);
                break;
            case 'add_recipe':
                $this->response['title'] = 'Recept Toevoegen';
                $main_element = new \vrklk\view\elements\FormPageElement('Recept Toevoegen', 4, $this->controller_form_array, $this->response['page']);
                break;
            case 'favorites':
                $this->response['title'] = 'Mijn Favorieten';
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
                $this->response['title'] = 'Zoekresultaten';
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getSearchRecipes(
                    4,
                    $this->response['page_number'],
                    $this->response['search_query'],
                );
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalSearchRecipes($this->response['search_query']) / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $this->response['page_number'],
                    total_pages: $total_pages,
                    page: $this->response['page'],
                );
                break;
            case 'details':
                $this->response['title'] = 'Recept Details';
                $main_element = new \vrklk\view\elements\RecipeDetailsElement($this->response['recipe_id'], $user_id);
                break;
            case 'shopping_list':
                $this->response['title'] = 'Mijn Boodschappenlijst';
                $main_element = new \vrklk\view\elements\ShoppingListElement(
                    $this->response['shopping_list'],
                    $this->response['user_adaptations'],
                );
                break;
            case 'add_test':
                $user_dao = new \vrklk\model\user\AddUserDAO();
                $user = $user_dao->registerUser('koen', 'kls@mail.com', 'pass', 'img.jpg');
                $comment_dao = new \vrklk\model\user\AddCommentDAO();
                $comment = $comment_dao->addComment(1, 1, 'test');
                $recipe_dao = new \vrklk\model\recipe\AddRecipeDAO();
                $measure = $recipe_dao->addMeasure(1, 'snufje', 'gram', 0.5);
                $recipe = $recipe_dao->storeNewRecipe(
                    \vrklk\model\site\TestDAO::getRecipeData('add_recipe_details'),
                    \vrklk\model\site\TestDAO::getRecipeData('add_recipe_ingredients'),
                    \vrklk\model\site\TestDAO::getRecipeData('add_recipe_steps'));
                $main_element = new \vrklk\view\elements\TextElement(
                    'user added: ' . $user . '<br>'
                        . 'comment added: ' . $comment . '<br>'
                        . 'measure added: ' . $measure . '<br>'
                        . 'recipe added: ' . $recipe . '<br>',
                    'Add DAO test results',
                );
                break;
            default:
                $this->response['title'] = '404';
                $main_element = new \vrklk\view\elements\TextElement(
                    'De gevraagde pagina is niet gevonden',
                    '404',
                );
                \ManKind\tools\dev\Logger::_echo('Invalid response page: '
                    . $this->response['page']);
        }
        $page = new \vrklk\view\VPage(
            $this->response['title'],
            $main_element,
            $user_id,
            $this->response['page']
        );
        $page->show();
    }

    //=========================================================================
    // PRIVATE
    //=========================================================================
}
