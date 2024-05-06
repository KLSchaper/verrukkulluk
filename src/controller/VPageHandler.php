<?php

namespace vrklk\controller;

use \vrklk\base\controller\Request,
    \vrklk\controller\ControllerData,
    \vrklk\controller\FormValidator;

class VPageHandler extends \vrklk\base\controller\BasePageHandler
{
    protected FormValidator $validator;

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function _validateGet(): void
    {
        switch ($this->requested_page) {
            case 'log_out':
                $this->response['page'] = 'home';
                ControllerData::logOutUser();
                // no break, falls through
            case 'home':
                $this->response['page_number'] = Request::getRequestVar('page_number', 1, true);
                break;
            case 'favorites':
                $this->response['page_number'] = Request::getRequestVar('page_number', 1, true);
                break;
            case 'details':
                $this->response['recipe_id'] = Request::getRequestVar('recipe_id', 0, true);
                break;
            case 'shopping_list';
                $this->response['shopping_list'] = ControllerData::getShoppingList();
                $this->response['user_adaptations'] = ControllerData::getUserAdaptations();
                break;
            case 'register':
                $this->validator = new FormValidator();
                $this->validator->setFormData(['form_values' => [], 'form_errors' => []]);
                break;
            case 'add_recipe':
                $this->validator = new FormValidator();
                $this->validator->setFormData(['form_values' => [], 'form_errors' => []]);
                break;
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid GET request: '
                    . $this->requested_page);
        }
    }

    protected function _validatePost(): void
    {
        $form_validity = true;
        $form_id = htmlspecialchars($_POST['form_id']);

        $form_dao = \ManKind\ModelManager::getFormDAO();
        $form_info = $form_dao->getFormInfo($form_id);
        $this->validator = new FormValidator();

        $this->response['post_values'] = [];
        foreach($form_info['fields'] as $field_id => $field_type) {
            $field_info = $form_dao->getFieldInfo($field_id, $field_type);
            if($field_info['type']!='comment') {
                if($field_info['grouping_id'] == 0) {
                    $validate_array = $this->validator->validateField($field_info, $form_dao);
                    if(!$validate_array['valid']) {
                        $form_validity = false;
                    }
                    $this->validator->setFormDataValue('form_values', $field_id, $validate_array['value']);
                    $this->validator->setFormDataValue('form_errors', $field_id, $validate_array['error']);
                    $this->response['post_values'][$field_info['name']] = $validate_array['value'];
                } else {
                    $group_info = $form_dao->getFieldInfo($field_info['grouping_id'], 'numeric_int');
                    $group_number = htmlspecialchars($_POST[$group_info['name']]);
                    $this->validator->setFormDataValue('error', $field_id, '');
                    for ($i=1; $i<=$group_number; $i++) {
                        $validate_array = $this->validator->validateField($field_info, $form_dao);
                        if(!$validate_array['valid']) {
                            $form_validity = false;
                        }
                        //TODO solve for multiple inputs of the same ID
                        $this->validator->setFormDataValue('form_values', $field_id, $validate_array['value']);
                        $this->validator->setFormDataValue('form_errors', $field_id, $validate_array['error']);
                        $this->response['post_values'][$field_info['name']] = $validate_array['value'];
                    }
                }
            }
        }

        if ($form_validity) {
            $form_validity = $this->validator->validateForm(
                $form_id,
                $this->response['post_values']
            );
        }

        if ($form_validity) {
            $this->validator->handlePost($form_id, $this->response);
        }
    }

    protected function _showResponse(): void
    {
        $user_id = ControllerData::getLoggedUser();
        switch ($this->response['page']) {
            case 'home':
                $this->response['title'] = 'Home';
                $page_number = $this->getKeyValue($this->response, 'page_number', 1);
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getHomeRecipes(
                    4,
                    $page_number,
                );
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalHomeRecipes() / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $page_number,
                    total_pages: $total_pages,
                    page: $this->response['page'],
                );
                break;
            case 'register':
                $this->response['title'] = 'Registreren';  
                $main_element = new \vrklk\view\elements\FormPageElement(
                    'Registreren',
                    6,
                    $this->validator->getFormData(),
                    $this->response['page']
                );
                break;
            case 'add_recipe':
                $this->response['title'] = 'Recept Toevoegen';
                $main_element = new \vrklk\view\elements\FormPageElement(
                    'Recept Toevoegen',
                    4,
                    $this->validator->getFormData(),
                    $this->response['page']
                );
                break;
            case 'favorites':
                $this->response['title'] = 'Mijn Favorieten';
                $page_number = $this->getKeyValue($this->response, 'page_number', 1);
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getFavoriteRecipes(
                    4,
                    $page_number,
                    $user_id,
                );
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalFavoriteRecipes($user_id) / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $page_number,
                    total_pages: $total_pages,
                    page: $this->response['page'],
                );
                break;
            case 'search':
                $this->response['title'] = 'Zoekresultaten';
                $page_number = $this->getKeyValue($this->response, 'page_number', 1);
                $recipe_id_array = \ManKind\ModelManager::getRecipeDAO()->getSearchRecipes(
                    4,
                    $page_number,
                    $this->response['search_query'],
                );
                $total_pages = ceil(\ManKind\ModelManager::getRecipeDAO()->getTotalSearchRecipes($this->response['search_query']) / 4);
                $main_element = new \vrklk\view\elements\RecipePageElement(
                    recipe_id_array: $recipe_id_array,
                    page_number: $page_number,
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
    private function getKeyValue(
        array $arr,
        string $key,
        mixed $default = false
    ): mixed {
        return (isset($arr[$key]) ? $arr[$key] : $default);
    }
}
