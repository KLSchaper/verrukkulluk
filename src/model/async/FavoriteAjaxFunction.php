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
            $this->data = 'Log in om iets aan je favorieten toe te voegen';
            http_response_code(401);
            return true;
        }

        $favorites_dao = \ManKind\ModelManager::getFavoritesDAO();

        $recipe_title = \ManKind\ModelManager::getRecipeDAO()->
            getRecipeTitle($this->recipe_id)['title'];
        $user_name = \ManKind\ModelManager::getUsersDAO()->
            getUserById($this->user_id)['name'];
        
        switch ($this->action) {
            case 'add':
                if (is_int($favorites_dao->addFavorite($this->recipe_id, $this->user_id))) {
                    $this->data = $recipe_title 
                        . ' is toegevoegd aan de favorieten van '
                        . $user_name;
                } else {
                    $this->data = 'FOUT: '
                        . $recipe_title 
                        . ' kon niet toegevoegd worden aan de favorieten van '
                        . $user_name;
                    http_response_code(500);
                }
                break;
            case 'remove':
                if ($favorites_dao->removeFavorite($this->recipe_id, $this->user_id)) {
                    $this->data = $recipe_title 
                        . ' verwijderd uit de favorieten van '
                        . $user_name;
                } else {
                    $this->data = 'FOUT: '
                        . $recipe_title 
                        . ' kon niet verwijderd worden uit de favorieten van '
                        . $user_name;
                    http_response_code(500);
                }
                break;
            default:
                $this->data = 'Ongeldige actie';
        }
        return true;
    }
}
