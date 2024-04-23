<?php

namespace vrklk\controller;

class VPageHandler extends \vrklk\base\controller\BasePageHandler
{
    protected function _validateGet(): bool
    {
        switch ($this->requested_page) {
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid GET request: '
                    . $this->requested_page);
                return false;
        }
    }

    protected function _validatePost(): bool
    {
        switch ($this->requested_page) {
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid POST request: '
                    . $this->requested_page);
                return false;
        }
    }

    protected function _showResponse(): bool
    {
        switch ($this->response['page']) {
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid response: '
                    . $this->response['page']);
                return false;
        }
    }

}
