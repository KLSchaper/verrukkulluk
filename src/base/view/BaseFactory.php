<?php

namespace vrklk\base\view;

abstract class BaseFactory
{
    abstract public function create(): \vrklk\base\view\BaseElement;
}
