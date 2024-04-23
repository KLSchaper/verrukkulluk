<?php

namespace vrklk\base\controller;

abstract class RESTfulHandler implements \vrklk\interfaces\iRequestHandler

{
    final public function handleRequest(): bool
    {
        return false;
    }
}
