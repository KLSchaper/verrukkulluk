<?php

namespace vrklk\model\user;

class UsersDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iUserDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getUserById(int $user_id): array {
        return [];
    }
}