<?php

namespace vrklk\base\controller;

use vrklk\base\controller\HandlerFactory;

class MainController implements \vrklk\interfaces\iRequestHandler
{
    protected $handler_factory;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct(HandlerFactory $handler_factory)
    {
        $this->handler_factory = $handler_factory;
    }

    public function handleRequest(): bool
    {
        $dispatch_to = $this->handler_factory->createHandler();
        if ($dispatch_to)
        {
            return $dispatch_to->handleRequest();
        }
        return false;
    }
}
