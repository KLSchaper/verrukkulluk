<?php

namespace vrklk\base\controller;

use \vrklk\base\controller\Request,
    \vrklk\base\model\BaseAjaxFunction,
    \vrklk\base\model\BaseAsyncModel;

abstract class BaseAjaxHandler extends \vrklk\base\controller\RESTfulHandler
{
    protected string $requested_function = '';
    protected ?BaseAjaxFunction $ajax_response;
    protected ?BaseAsyncModel $async_model;

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function _generateResponse(): void
    {
        $this->requested_function = Request::getRequestVar('action');
        $this->_createFunction();
        $this->_executeFunction();
    }

    protected function _reportError(\Throwable $ex): void
    {
        // \ManKind\cms\utils\HttpUtils::errorHeader('501 ' . $this->requested_function . ' not implemented');
        echo $ex->getMessage();
        \ManKind\tools\dev\Logger::_error($ex);
    }

    protected function _createFunction(): bool
    {
        $res = $this->_createAsyncModel()->createResponse($this->requested_function);
        if ($res !== false) {
            $this->ajax_response = $res;
            return true;
        }
        throw new \Error($this->async_model->getErrors());
    }

    protected function _executeFunction(): bool
    {
        return $this->ajax_response->execute();
    }

    abstract protected function _createAsyncModel(): BaseAsyncModel;
}
