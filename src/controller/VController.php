<?php

namespace vrklk\controller;

class VController extends \vrklk\base\controller\Controller
{
    protected array $controller_form_array;

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
                $this->response['page_number'] = $this->getRequestVar('page_number', false, 1, true);
                break;
            case 'details':
                $this->response['title'] = 'Recept Details';
                $this->response['recipe_id'] = $this->getRequestVar('recipe_id', false, 0, true);
                break;
            case 'shopping_list';
                $this->response['title'] = 'Mijn Boodschappenlijst';
                break;
            case 'add_to_list';
                $this->response['page'] = 'details';
                $this->response['title'] = 'Recept Details';
                $this->response['recipe_id'] = $this->getRequestVar('recipe_id', false, 0, true);
                $this->addRecipeToShoppingList($this->response['recipe_id']);
                break;
            default:
                $this->response['title'] = '404';
        }
    }

    protected function validatePost(): void
    {
        $form_validity = true;
        $form_id = htmlspecialchars($_POST['form_id']);

        $form_dao = \ManKind\ModelManager::getFormDAO();
        $form_info = $form_dao->getFormInfo($form_id);

        $form_fields = [];
        foreach($form_info['fields'] as $field_id => $field_type) {
            $field_info = $form_dao->getFieldInfo($field_id, $field_type);
            if($field_info['grouping_id'] == 0) {
                $validate_array = $this->validateField($field_info, $form_dao);
                if(!$validate_array['valid']) {
                    $form_validity = false;
                }
                $this->controller_form_array['value'][$field_id] = $validate_array['value'];
                $this->controller_form_array['error'][$field_id] = $validate_array['error'];
            } else {
                $group_info = $form_dao->getFieldInfo($field_info['grouping_id'], 'numeric_int');
                $group_number = htmlspecialchars($_POST[$group_info['name']]);
                $this->controller_form_array['error'][$field_id] = '';
                for ($i=1; $i<=$group_number; $i++) {
                    $validate_array = $this->validateField($field_info, $form_dao);
                    if(!$validate_array['valid']) {
                        $form_validity = false;
                    }
                    $this->controller_form_array['value'][$field_id][] = $validate_array['value'];
                    $this->controller_form_array['error'][$field_id] .= $validate_array['error'];
                }
            }
            
            //$form_fields[$field_info['name']] = $field_info;
        }

        if ($form_validity) {
            $form_validity = $this->validateForm($form_id, $form_dao);
        }

        if ($form_validity) {
            $this->handlePost($form_id);
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
                    6,
                    []
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
                $main_element = new \vrklk\view\elements\RecipeDetailsElement($this->response['recipe_id'], $user_id);
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
    private function addRecipeToShoppingList(int $recipe_id): void {
        echo 'adding recipe ' . $recipe_id . ' to shopping list!';
    }
    
    private function getKeyValue(
        array $arr,
        string $key,
        mixed $default = false
    ): mixed {
        return (isset($arr[$key]) ? $arr[$key] : $default);
    }

    private function validateField($field_info, $form_dao): array {
        $posted_value = isset($_POST[$field_info['name']]) ? $_POST[$field_info['name']] : '';
        $validate_array['valid'] = true;
        $validate_array['error'] = '';

        if ($posted_value) {
            switch ($field_info['validation']) {
                case 'text_validation':
                    $posted_value = htmlspecialchars($posted_value);
                    break;

                case 'email_validation':
                    $posted_value = filter_var($posted_value, FILTER_VALIDATE_EMAIL);
                    break;

                case 'file_validation':
                    // can't be done in time
                    
                    // test on extensions (jpg, jpeg, gif, png, (webp))
                    // the actual translation is done later, after the post is done.
                    break;

                case 'dropdown_validation':
                    $posted_value = htmlspecialchars($posted_value);
                    $dropdown_options = $form_dao->getDropdownInfo[$field_info['id']];
                    if (!in_array($posted_value, $dropdown_options)) {
                        $posted_value = false;
                    }
                    break;

                case 'numeric_non_zero_validation':
                    $filter_options = [];
                    if (isset($field_info['min_value'])) {
                        $filter_options['min_range'] = $field_info['min_value'];
                    }
                    if (isset($field_info['max_value'])) {
                        $filter_options['max_range'] = $field_info['max_value'];
                    }
                    $posted_value = filter_var($posted_value, FILTER_VALIDATE_FLOAT, ['options' => $filter_options]);
                    if ($posted_value === 0) {
                        $posted_value = false;
                    }
                    break;

                case 'numeric_int_validation':
                    $filter_options = [];
                    if (isset($field_info['min_value'])) {
                        $filter_options['min_range'] = $field_info['min_value'];
                    }
                    if (isset($field_info['max_value'])) {
                        $filter_options['max_range'] = $field_info['max_value'];
                    }
                    $posted_value = filter_var($posted_value, FILTER_VALIDATE_INT, ['options' => $filter_options]);
                    break;

                default:
                    $posted_value = false;
            }
        }

        $validate_array['value'] = $posted_value;

        if ($posted_value === false) {
            $validate_array['valid'] = false;
            $validate_array['error'] = 'invalid input';
        }

        if ($posted_value === '' && $field_info['required']) {
            $validate_array['valid'] = false;
            $validate_array['error'] = $field_info['name'] . ' is empty';
        }

        return $validate_array;
    }

    private function validateForm($form_id): bool {
        $form_values = $this->controller_form_array['form_values'];
        
        switch ($form_id) {
            case 1:
                //login
                $user_dao =  \ManKind\ModelManager::getUserDAO();
                $user_array = $user_dao->checkUserLogin($form_values['email']);
                if (!empty($user_array)) {
                    if ($form_values['password'] == $user_array['password']) {
                        $valid = true;
                        // store user id
                        logInUser($form_values['user_id']);
                    } else {
                        $valid = false;
                        $this->controller_form_array['form_errors']['2'] = 'incorrect password';
                    }
                } else {
                    $valid = false;
                    $this->controller_form_array['form_errors']['1'] = 'no user with that email address exists';
                }
                break;

            case 2:
                $valid = true;
                break;

            case 3:
                $valid = true;
                break;

            case 4:
                //recipe

                break;

            case 5:
                //measure
                break;

            case 6:
                //register
                $user_dao =  \ManKind\ModelManager::getUserDAO();
                if ($user_dao->checkUserRegister($form_values['email'])) {
                    $valid = false;
                    $this->controller_form_array['form_errors']['28'] = 'email address already in use';
                } else {
                    if ($form_values['password'] == $form_values['repeat_password']) {
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->controller_form_array['form_errors']['30'] = 'repeat password doesn\'t match password';
                    }
                }
                break;
            default:
                $valid = false;
        }

        return $valid;
    }

    private function handlePost($form_id) {
        switch ($form_id) {
            case '1':
                // login
                break;

            case '2':
                // comment
                break;

            case '3':
                // search
                break;

            case '4':
                // recipe
                break;

            case '5':
                // measure
                break;

            case '6':
                // register
                break;
        }
    }
}
