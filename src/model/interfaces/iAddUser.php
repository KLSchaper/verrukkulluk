<?php

namespace vrklk\model\interfaces;

interface iAddUser
{
    public function registerUser(
        string $name,
        string $email,
        string $password,
        string $img
    ): int | false;
}
