<?php
namespace vrklk\model\interfaces;

interface iFooterDAO
{
    public function getFooterTitle() : string;
    public function getContactInfo() : array;
}