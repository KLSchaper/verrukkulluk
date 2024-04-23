<?php

namespace vrklk\base\controller;

class MainController implements \vrklk\interfaces\iRequestHandler
{
    protected $handler_factory;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct(\vrklk\base\controller\HandlerFactory $handler_factory)
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
