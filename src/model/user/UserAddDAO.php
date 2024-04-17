<?php

namespace vrklk\model\user;

class UserAddDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iAddComment,
    \vrklk\model\interfaces\iAddUser
{
    public function addComment(
        int $recipe_id,
        int $user_id,
        string $text
    ): int|false {
        return 0; // TODO implement function
    }

    public function registerUser(
        string $name,
        string $email,
        string $password,
        string $img
    ): int|false {
        return 0; // TODO implement function
    }
}
