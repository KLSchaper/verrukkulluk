<?php

namespace vrklk\controller;

class FormValidator
{
    protected array $form_data;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getFormData(): array
    {
        return $this->form_data;
    }

    public function setFormData(array $form_data): void
    {
        $this->form_data = $form_data;
    }

    public function setFormDataValue(
        string $index_1,
        mixed $index_2,
        mixed $value
    ): void {
        $this->form_data[$index_1][$index_2] = $value;
    }

    public function validateField(array $field_info, object $form_dao): array 
    {
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

    public function validateForm(int $form_id, array $form_values): bool 
    {
        // $form_values = $this->response['post_values'];
        
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
                        $this->form_data['form_errors']['2'] = 'incorrect password';
                    }
                } else {
                    $valid = false;
                    $this->form_data['form_errors']['1'] = 'no user with that email address exists';
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
                    $this->form_data['form_errors']['28'] = 'email address already in use';
                } else {
                    if ($form_values['password'] == $form_values['repeat_password']) {
                        $valid = true;
                    } else {
                        $valid = false;
                        $this->form_data['form_errors']['30'] = 'repeat password doesn\'t match password';
                    }
                }
                break;
            default:
                $valid = false;
        }

        return $valid;
    }

    public function handlePost(int $form_id, array &$response) {
        $form_values = $response['post_values'];
        switch ($form_id) {
            case '1':
                // login
                // already done in validation.
                break;

            case '2':
                // comment
                $user_id = \vrklk\controller\ControllerData::getLoggedUser();
                $recipe_id = $response['recipe_id'];
                $text = $form_values['comment'];

                $comment_dao = \ManKind\ModelManager::getAddCommentDAO();
                $comment_dao->addComment($recipe_id, $user_id, $text);
                break;

            case '3':
                // search
                $response['page'] = 'search';
                $response['search_query'] = $form_values['search'];
                $response['page_number'] = 1;
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
                // $this->request['page'] = 'home';
                $response['page'] = 'home';
                break;
        }
    }
}
