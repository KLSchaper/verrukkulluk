<?php

namespace vrklk\base\controller;

use \vrklk\base\controller\Request;

abstract class BasePageHandler extends \vrklk\base\controller\RESTfulHandler

{
    protected string $requested_page;
    protected array $response;

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function _generateResponse(): bool
    {
        $this->requested_page = Request::getRequestVar(
            key: 'page',
            default: 'home',
        );
        return ($this->_validateRequest() && $this->_showResponse());
    }

    protected function _reportError(\Throwable $e): void
    {
        \ManKind\tools\dev\Logger::_error($e);
    }

    protected function _validateRequest(): bool
    {
        $this->response['page'] = $this->requested_page;
        if (Request::isPost()) {
            return $this->_validatePost();
        } else {
            return $this->_validateGet();
        }
    }

    abstract protected function _validateGet(): bool;
    abstract protected function _validatePost(): bool;
    abstract protected function _showResponse(): bool;
}
