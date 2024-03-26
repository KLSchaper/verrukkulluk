<?php
namespace vrklk\model\user;

class FavoritesDAO extends \vrklk\base\model\BaseDAO implements 
    \vrklk\model\interfaces\iFavoritesDAO
{
    public function checkFavorite(int $recipe_id, int $user_id) : bool
    {
        $favorite = $this->crud->selectOne(
            "SELECT 1" 
            ." FROM favorites" 
            ." WHERE recipe_id=:recipe_id AND user_id=:user_id",
            [
                'recipe_id'=>[$recipe_id, true],
                'user_id'=>[$user_id, true],
            ],
        );
        return boolval($favorite);
    }
}