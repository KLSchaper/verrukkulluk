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
        return 0; // TODO implement function
    }
}
