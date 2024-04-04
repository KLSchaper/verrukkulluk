<?php

namespace vrklk\view\collections;

class MenuCollection extends \vrklk\base\view\BaseCollection
{
    protected function createItems(): void
    {
        if (!isset($this->items_info) || !isset($this->factory) 
            || !$this->factory instanceof \vrklk\view\factories\MenuItemFactory) {
            $this->items = false;
            exit();
        }
        foreach ($this->items_info as $title => $properties) {
            $this->items[] = $this->factory->create($title, $properties);
        }
    }
}