<?php

namespace vrklk\model\user;

class AddUserDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iAddUser
{
    public function registerUser(
        string $name,
        string $email,
        string $password,
        string $img
    ): int|false {
        return $this->crud->doInsert(
            "INSERT INTO users (name, email, password, img)"
                . " VALUES (:name, :email, :password, :img)",
            [
                'name' => [$name, false],
                'email' => [$email, false],
                'password' => [$password, false],
                'img' => [$img, false],
            ]
        );
    }
}
