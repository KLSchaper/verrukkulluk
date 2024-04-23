<?php

namespace vrklk\base\controller;

abstract class RESTfulHandler implements \vrklk\interfaces\iRequestHandler

{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    final public function handleRequest(): bool
    {
        $result = false;
        try {
            ob_start();
            if ($this->_generateResponse()) {
                echo ob_get_clean();
                $result = true;
            }
        } catch (\Throwable $ex) {
            ob_end_clean();
            $this->_reportError($ex);
        }
        return $result;
    }

    //=========================================================================
    // PROTECTED
    //=========================================================================
    abstract protected function _generateResponse(): bool;
    abstract protected function _reportError(\Throwable $ex): void;
}
