<?php
namespace vrklk\model\interfaces;

interface iLoginDAO
{
    public function getLoginTitle(bool $logged_user) : string;
    public function getLoginContent(bool $logged_user) : array;
}