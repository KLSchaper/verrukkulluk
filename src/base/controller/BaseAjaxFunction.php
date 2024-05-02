<?php

namespace vrklk\base\controller;

abstract class BaseAjaxFunction extends BaseAsyncFunction
{
    //=========================================================================
    // PROTECTED
    //=========================================================================
    abstract protected function _getData(): bool;

    protected function _sendData(): bool
    {
        echo $this->data;
        return true;
    }
}
