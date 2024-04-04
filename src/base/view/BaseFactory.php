<?php

namespace vrklk\base\view;

abstract class BaseFactory
{
    abstract public function create(
        string $name,
        array $properties
    ): \vrklk\base\view\BaseElement;
}
