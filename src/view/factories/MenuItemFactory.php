<?php

namespace vrklk\view\factories;

class MenuItemFactory extends \vrklk\base\view\BaseFactory
{
    public function create(
        string $name,
        array $properties
    ): \vrklk\view\elements\MenuItemElement {
        switch ($properties['type']) {
            case 'link':
                return new \vrklk\view\elements\MenuItemElement(
                    $name,
                    $properties['title'],
                    $properties['display_order']
                );
            default:
                return new \vrklk\view\elements\MenuItemElement(
                    $name,
                    $properties['title'],
                    $properties['display_order']
                );
        }
    }
}
