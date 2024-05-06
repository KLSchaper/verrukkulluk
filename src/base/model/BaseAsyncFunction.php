<?php

namespace vrklk\base\model;

abstract class BaseAsyncFunction
{
    protected $data;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    final public function execute(): bool
    {
        if ($this->_getData()) {
            return $this->_sendData();
        }
        return false;
    }

    //=========================================================================
    // PROTECTED
    //=========================================================================
    abstract protected function _getData(): bool;
    abstract protected function _sendData(): bool;
}
