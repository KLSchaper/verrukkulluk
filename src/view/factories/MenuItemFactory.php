<?php

namespace vrklk\view\factories;

class MenuItemFactory extends \vrklk\base\view\BaseFactory
{
    public function create(): \vrklk\view\elements\MenuItemElement
    {
        return new \vrklk\view\elements\MenuItemElement;
    }
}
