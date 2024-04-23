<?php

namespace vrklk\base\controller;

class HandlerFactory
{
    public function createHandler(): \vrklk\interfaces\iRequestHandler
    {
        $requested_handler = 'page'; // TODO replace with getRequestVar function somehow
        \ManKind\tools\dev\Logger::_echo($requested_handler . '-call made');
        switch ($requested_handler) {
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
