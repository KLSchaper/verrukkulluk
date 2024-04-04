<?php

namespace vrklk\base\view;

abstract class BaseCollection
{
    private $items_info;
    private $factory;
    private $items;

    public function __construct(
        array $items_info,
        \vrklk\base\view\BaseFactory $factory
    ) {
        $this->items_info = $items_info;
        $this->factory = $factory;
        $this->items = [];
    }

    public function getItems(): array|false
    {
        if (count($this->items) === 0) {
            $this->createItems();
        }
        return $this->items;
    }

    abstract protected function createItems(): void;
}
