<?php

namespace vrklk\controller;

use \vrklk\base\controller\Request,
    \vrklk\controller\ControllerData;

class TestPageHandler extends \vrklk\base\controller\BasePageHandler
{
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
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid TEST GET request: '
                    . $this->requested_page);
        }
    }

    protected function _validatePost(): void
    {
        
    }

    protected function _showResponse(): void
    {
        $user_id = ControllerData::getLoggedUser();
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
                    'De gevraagde test pagina is niet gevonden',
                    '404',
                );
                \ManKind\tools\dev\Logger::_echo('Invalid test response page: '
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
}
