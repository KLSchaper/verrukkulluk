<?php
namespace vrklk\model\interfaces;

interface iMenuDAO
{
    public function getMenuItems(bool $logged_user) : array;
}