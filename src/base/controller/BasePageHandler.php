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
    protected function _generateResponse(): void
    {
        $this->requested_page = Request::getRequestVar(
            key: 'page',
            default: 'home',
        );
        $this->_validateRequest();
        $this->_showResponse();
    }

    protected function _reportError(\Throwable $e): void
    {
        \ManKind\tools\dev\Logger::_error($e);
    }

    protected function _validateRequest(): void
    {
        $this->response['page'] = $this->requested_page;
        if (Request::isPost()) {
            $this->_validatePost();
        } else {
            $this->_validateGet();
        }
    }

    abstract protected function _validateGet(): void;
    abstract protected function _validatePost(): void;
    abstract protected function _showResponse(): void;
}
