<?php

namespace vrklk\model\user;

class AddCommentDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iAddComment
{
    public function addComment(
        int $recipe_id,
        int $user_id,
        string $text
    ): int|false {
        return 0; // TODO implement function
    }
}
