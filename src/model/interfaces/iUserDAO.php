<?php

namespace vrklk\model\interfaces;

interface iUserDAO
{
    public function getUserById(int $user_id): array|false;
}
