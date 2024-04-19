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
    public function checkUserLogin($email): array|false {
        $check_login_query = '
            SELECT id, password
            FROM users
            WHERE email = :email
        ';
        $parameters = ['email' => [$email, false]];
        $user_array = $this->crud->selectOne($check_login_query, $parameters);
        return $user_array;
    }

    public function checkUserRegister($email): bool {
        $check_register_query = '
            SELECT id
            FROM users
            WHERE email = :email
        ';
        $parameters = ['email' => [$email, false]];
        return boolval ($this->crud->selectOne($check_register_query, $parameters));
    }
}