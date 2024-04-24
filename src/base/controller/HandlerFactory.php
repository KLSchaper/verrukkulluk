<?php

namespace vrklk\base\controller;

class HandlerFactory
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function createHandler(): \vrklk\interfaces\iRequestHandler
    {
        $requested_handler = \vrklk\base\controller\Request::getRequestVar(
            key: 'handler',
            default: 'page',
        );
        \ManKind\tools\dev\Logger::_echo($requested_handler . '-call made');
        switch ($requested_handler) {
            case 'test':
                return new \vrklk\controller\TestPageHandler();
            case 'page':
                return new \vrklk\controller\VPageHandler();
            case 'ajax':
                return new \vrklk\controller\VAjaxHandler();
            default:
                throw new \Exception('Unknown handler requested: '
                    . $requested_handler);
        }
    }
}
