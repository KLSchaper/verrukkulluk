<?php

namespace vrklk\model\user;

class FavoritesDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iFavoritesDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function checkFavorite(int $recipe_id, int $user_id): bool
    {
        $favorite = $this->crud->selectOne(
            "SELECT 1"
                . " FROM favorites"
                . " WHERE recipe_id=:recipe_id AND user_id=:user_id",
            [
                'recipe_id' => [$recipe_id, true],
                'user_id' => [$user_id, true],
            ],
        );
        return boolval($favorite);
    }

    public function addFavorite(int $recipe_id, int $user_id): int|false
    {
        return $this->crud->doInsert(
            "INSERT INTO favorites (recipe_id, user_id)"
                . " VALUES (:recipe_id, :user_id)",
            [
                'recipe_id' => [$recipe_id, true],
                'user_id' => [$user_id, true],
            ]
        );
    }

    public function removeFavorite(int $recipe_id, int $user_id): int|false
    {
        return $this->crud->doDelete(
            "DELETE FROM favorites"
                . " WHERE recipe_id = :recipe_id"
                . " AND user_id = :user_id",
            [
                'recipe_id' => [$recipe_id, true],
                'user_id' => [$user_id, true],
            ]
        );
    }
}
