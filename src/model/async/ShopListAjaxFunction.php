<?php

namespace vrklk\model\async;

use \vrklk\base\controller\Request,
    \vrklk\controller\ControllerData;

class ShopListAjaxFunction extends \vrklk\base\model\BaseAjaxFunction
{
    protected string $action;
    protected int $recipe_id;
    protected int $product_id;

    public function __construct(
        string $action,
        int $recipe_id = 0,
        int $product_id = 0
    ) {
        $this->action = $action;
        $this->recipe_id = $recipe_id;
        $this->product_id = $product_id;
    }
    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function _getData(): bool
    {
        switch ($this->action) {
            case 'add':
                $recipe_title = \ManKind\ModelManager::getRecipeDAO()->
                    getRecipeTitle($this->recipe_id)['title'];
                ControllerData::addRecipeToShoppingList($this->recipe_id);
                $this->data = 'De ingrediënten voor '
                    . $recipe_title 
                    . ' zijn toegevoegd aan je boodschappenlijst';
                break;
            default:
                $this->data = 'Ongeldige actie';
                http_response_code(501);
        }
        return true;
    }
}
