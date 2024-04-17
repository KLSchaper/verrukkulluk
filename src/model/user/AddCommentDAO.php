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
        return $this->crud->doInsert(
            "INSERT INTO comments (recipe_id, user_id, text)"
                . " VALUES (:recipe_id, :user_id, :text)",
            [
                'recipe_id' => [$recipe_id, true],
                'user_id' => [$user_id, true],
                'text' => [$text, false],
            ]
        );
    }
}
