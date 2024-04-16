<?php

namespace vrklk\model\user;

class UsersDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iUserDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getUserById(int $user_id): array|false {
        return $this->crud->selectOne(
            "SELECT *"
                . " FROM users"
                . " WHERE id=:user_id",
            [
                'user_id' => [$user_id, true],
            ],
        );
    }
}