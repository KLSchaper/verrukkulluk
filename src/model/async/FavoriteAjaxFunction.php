<?php

namespace vrklk\model\async;

class FavoriteAjaxFunction extends \vrklk\base\model\BaseAjaxFunction
{
    protected string $action;
    protected int $recipe_id;
    protected int $user_id;

    public function __construct(string $action, int $recipe_id, int $user_id)
    {
        $this->action = $action;
        $this->recipe_id = $recipe_id;
        $this->user_id = $user_id;
    }
    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function _getData(): bool
    {
        if ($this->user_id === 0) {
            $this->data = '';
            return true;
        }

        $recipe_title = \ManKind\ModelManager::getRecipeDAO()->
            getRecipeTitle($this->recipe_id)['title'];
        $user_name = \ManKind\ModelManager::getUsersDAO()->
            getUserById($this->user_id)['name'];
        
        switch ($this->action) {
            case 'add':
                $this->data = $recipe_title 
                    . ' toegevoegd aan de favorieten van '
                    . $user_name;
                break;
            case 'remove':
                $this->data = $recipe_title 
                    . ' verwijderd uit de favorieten van '
                    . $user_name;
                break;
            default:
                $this->data = 'Ongeldige actie';
        }
        return true;
    }
}
