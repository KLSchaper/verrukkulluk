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
            case 'register':
                $this->controller_form_array = ['form_values' => [], 'form_errors' => []];
                break;
            case 'add_recipe':
                $this->controller_form_array = ['form_values' => [], 'form_errors' => []];
                break;
        }

    }
    
    protected function validateGeneral(): void
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
            case 'register':
                $this->response['title'] = 'Registreren';  
                break;
            case 'add_recipe':
                $this->response['title'] = 'Recept Toevoegen';
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

        $this->response['post_values'] = [];
        foreach($form_info['fields'] as $field_id => $field_type) {
            $field_info = $form_dao->getFieldInfo($field_id, $field_type);
            if($field_info['type']!='comment') {
                if($field_info['grouping_id'] == 0) {
                    $validate_array = $this->validateField($field_info, $form_dao);
                    if(!$validate_array['valid']) {
                        $form_validity = false;
                    }
                    $this->controller_form_array['form_values'][$field_id] = $validate_array['value'];
                    $this->controller_form_array['form_errors'][$field_id] = $validate_array['error'];
                    $this->response['post_values'][$field_info['name']] = $validate_array['value'];
                } else {
                    $group_info = $form_dao->getFieldInfo($field_info['grouping_id'], 'numeric_int');
                    $group_number = htmlspecialchars($_POST[$group_info['name']]);
                    $this->controller_form_array['error'][$field_id] = '';
                    for ($i=1; $i<=$group_number; $i++) {
                        $validate_array = $this->validateField($field_info, $form_dao);
                        if(!$validate_array['valid']) {
                            $form_validity = false;
                        }
                        //TODO solve for multiple inputs of the same ID
                        $this->controller_form_array['form_values'][$field_id] = $validate_array['value'];
                        $this->controller_form_array['form_errors'][$field_id] = $validate_array['error'];
                        $this->response['post_values'][$field_info['name']] = $validate_array['value'];
                    }
                }
            }
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
                    [],
                    $this->response['page']
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
                $main_element = new \vrklk\view\elements\FormPageElement('Registreren', 6, $this->controller_form_array, $this->response['page']);
                break;
            case 'add_recipe':
                $main_element = new \vrklk\view\elements\FormPageElement('Recept Toevoegen', 4, $this->controller_form_array, $this->response['page']);
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
                $recipe = $recipe_dao->storeNewRecipe([
                    'title' => 'stamppot',
                    'img' => 'stamppot.webp',
                    'blurb' => 'lekker',
                    'people' => 4,
                    'cuisine_id' => 6,
                    'type' => 'meat',
                    'descr' => 'een winterse klassieker',
                    'user_id' => 1
                ], [
                    [
                        'ingredient_id' => 1,
                        'quantity' => 3.14,
                        'measure_id' => $measure
                    ],
                    [
                        'ingredient_id' => 11,
                        'quantity' => 8,
                        'measure_id' => 6
                    ],
                    [
                        'ingredient_id' => 13,
                        'quantity' => 0.5,
                        'measure_id' => 2
                    ],
                ], [
                    1 => 'doe iets',
                    2 => 'doe nog iets',
                    3 => 'wacht even',
                    4 => 'eet smakelijk!'
                ]);
                $main_element = new \vrklk\view\elements\TextElement(
                    'user added: ' . $user . '<br>'
                        . 'comment added: ' . $comment . '<br>'
                        . 'measure added: ' . $measure . '<br>'
                        . 'recipe added: ' . $recipe . '<br>',
                    'Add DAO test results',
                );
                break;
            default:
                $main_element = new \vrklk\view\elements\TextElement(
                    'De gevraagde pagina is niet gevonden',
                    '404',
                );
        }
        $page = new \vrklk\view\VPage($this->response['title'], $main_element, $user_id, $this->response['page']);
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
                    $dropdown_info = $form_dao->getDropdownInfo($field_info['id']);
                    $dropdown_options = [];
                    foreach ($dropdown_info as $option) {
                        $dropdown_options[] = isset($option['value']) ? $option['value'] : $option['name'];
                    }

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
        $form_values = $this->response['post_values'];
        
        switch ($form_id) {
            case 1:
                //login
                $user_dao =  \ManKind\ModelManager::getUsersDAO();
                $user_array = $user_dao->checkUserLogin($form_values['email']);
                if (!empty($user_array)) {
                    if ($form_values['password'] == $user_array['password']) {
                        $valid = true;
                        \vrklk\controller\ControllerData::logInUser($user_array['id']);
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
                $valid = true;
                $add_recipe_dao = \ManKind\ModelManager::getAddRecipeDAO();
                if ($add_recipe_dao->checkRecipeName($form_values['recipe_name'])){
                    $valid = false;
                } else {
                    for ($i = 1; $i <= $form_values['number_of_ingredients']; $i++) {
                        $ingredient_name = $form_values['ingredient_choice_'.$i];
                        $measure_name = $form_values['measure_choice_'.$i];
                        $valid = $add_recipe_dao->checkIngredientMeasure($ingredient_name, $measure_name);
                    }
                }
                break;

            case 5:
                //measure
                $add_recipe_dao = \ManKind\ModelManager::getAddRecipeDAO();
                $valid = !$add_recipe_dao->checkMeasureName($form_values['measure_name']);
                break;

            case 6:
                //register
                $user_dao =  \ManKind\ModelManager::getUsersDAO();
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
        $form_values = $this->response['post_values'];
        switch ($form_id) {
            case '1':
                // login
                // already done in validation.
                break;

            case '2':
                // comment
                $user_id = \vrklk\controller\ControllerData::getLoggedUser();
                $recipe_id = $this->response['recipe_id'];
                $text = $form_values['comment'];

                $comment_dao = \ManKind\ModelManager::getAddCommentDAO();
                $comment_dao->addComment($recipe_id, $user_id, $text);
                break;

            case '3':
                // search
                $this->response['page'] = 'search';
                $this->response['search_query'] = $form_values['search'];
                $this->response['page_number'] = 1;
                break;

            case '4':
                // recipe
                $add_recipe_dao = \ManKind\ModelManager::getAddRecipeDAO();

                $title = $form_values['recipe_name'];
                $img = '';
                $blurb = $form_values['recipe_blurb'];
                $people = $form_values['people'];
                $cuisine_id = $add_recipe_dao->getCuisineByName($form_values['cuisine_choice']);
                $type = $add_recipe_dao->getTypeByName($form_values['type']);
                $descr = $form_values['recipe_description'];
                $user_id = \vrklk\controller\ControllerData::getLoggedUser();
                
                $recipe_values = [
                    'title' => $title,
                    'img' => $img,
                    'blurb' => $blurb,
                    'people' => $people,
                    'cuisine_id' => $cuisine_id,
                    'type' => $type,
                    'descr' => $descr,
                    'user_id' => $user_id
                ];

                $ingredient_values = [];
                for ($i = 1; $i <= $form_values['number_of_ingredients']; $i++) {
                    $ingredient_id = $add_recipe_dao->getIngredientByName($form_values['ingredient_choice_'.$i]);
                    $quantity = $form_values['quantity_'.$i];
                    $measure = $add_recipe_dao->getMeasureByName($form_values['measure_choice_'.$i]);

                    $ingredient_values[] = ['ingredient_id' => $ingredient_id, 'quantity'=> $quantity,'measure_id'=> $measure];
                }

                $prep_step_values = [];
                for ($i = 1; $i <= $form_values['number_of_steps']; $i++) {
                    $prep_step_values[strval($i)] = $form_values['prep_step_'.$i];
                }

                $add_recipe_dao->testRecipe($recipe_values, $ingredient_values, $prep_step_values);
                break;

            case '5':
                // measure
                $add_recipe_dao = \ManKind\ModelManager::getAddRecipeDAO();
                $ingredient_id = /* hidden field in post */ $form_values['measure_ingredient_id'];
                $name = $form_values['measure_name'];
                $unit = $form_values['measure_unit'];
                $quantity = $form_values['measure_quantity'];

                $add_recipe_dao->addMeasure($ingredient_id, $name, $unit, $quantity);
                break;

            case '6':
                // register
                $name = $form_values['username'];
                $email = $form_values['email'];
                $password = $form_values['password'];

                $add_user_dao = \ManKind\ModelManager::getAddUserDAO();
                $new_user_id = $add_user_dao->registerUser($name, $email, $password, '');
                \vrklk\controller\ControllerData::logInUser($new_user_id);
                $this->request['page'] = 'home';
                $this->response['page'] = 'home';
                break;
        }
    }
}
