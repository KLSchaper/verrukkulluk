<?php
namespace vrklk\model\interfaces;

interface iAddComment
{
    public function addComment(
        int $recipe_id,
        int $user_id,
        string $text
    ) : int | false;
}