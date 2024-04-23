<?php

namespace vrklk\base\controller;

abstract class BasePageHandler extends \vrklk\base\controller\RESTfulHandler

{
    protected string $requested_page;

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function _generateResponse(): bool
    {
        $this->requested_page = \vrklk\base\controller\Request::getRequestVar(
            key: 'page',
            default: 'home',
        );
        return $this->_createPage();
    }

    protected function _reportError(\Throwable $e): void
    {
        \ManKind\tools\dev\Logger::_error($e);
    }

    abstract protected function _createPage(): bool;
}
