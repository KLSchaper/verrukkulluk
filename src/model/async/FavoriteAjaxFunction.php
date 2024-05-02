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
            return true;
        }
        
        switch ($this->action) {
            case 'add':
                $this->data = 'adding recipe ' . $this->recipe_id . ' to favorites for user ' . $this->user_id;
                break;
            case 'remove':
                $this->data = 'removing recipe ' . $this->recipe_id . ' from favorites for user ' . $this->user_id;
                break;
            default:
                $this->data = 'invalid favorite action';
        }
        return true;
    }
}
