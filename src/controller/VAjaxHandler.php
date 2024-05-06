<?php

namespace vrklk\controller;

use \vrklk\base\controller\Request,
    \vrklk\controller\ControllerData;

class VAjaxHandler extends \vrklk\base\controller\BaseAjaxHandler
{
    protected function _createAsyncFunction(): \vrklk\base\model\BaseAsyncFunction
    {
        switch ($this->requested_function) {
            case 'add_favorite':
                $recipe_id = Request::getRequestVar('recipe_id', 0, true);
                $user_id = ControllerData::getLoggedUser();
                return new \vrklk\model\async\FavoriteAjaxFunction(
                    action: 'add',
                    recipe_id: $recipe_id,
                    user_id: $user_id,
                );
            case 'remove_favorite':
                $recipe_id = Request::getRequestVar('recipe_id', 0, true);
                $user_id = ControllerData::getLoggedUser();
                return new \vrklk\model\async\FavoriteAjaxFunction(
                    action: 'remove',
                    recipe_id: $recipe_id,
                    user_id: $user_id,
                );
            case 'add_to_list';
                $recipe_id = Request::getRequestVar('recipe_id', 0, true);
                return new \vrklk\model\async\ShopListAjaxFunction(
                    action: 'add',
                    recipe_id: $recipe_id,
                );
            default:
                http_response_code(501);
                return new \vrklk\model\async\AjaxFunction();
        }
    }
}
