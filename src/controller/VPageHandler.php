<?php

namespace vrklk\controller;

class VPageHandler extends \vrklk\base\controller\BasePageHandler
{
    protected function _validateGet(): void
    {
        switch ($this->requested_page) {
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid GET request: '
                    . $this->requested_page);
        }
    }

    protected function _validatePost(): void
    {
        switch ($this->requested_page) {
            default:
                \ManKind\tools\dev\Logger::_echo('Invalid POST request: '
                    . $this->requested_page);
        }
    }

    protected function _showResponse(): void
    {
        $user_id = \vrklk\controller\ControllerData::getLoggedUser();
        switch ($this->response['page']) {
            default:
                $this->response['title'] = '404';
                $main_element = new \vrklk\view\elements\TextElement(
                    'De gevraagde pagina is niet gevonden',
                    '404',
                );
                \ManKind\tools\dev\Logger::_echo('Invalid response page: '
                    . $this->response['page']);
        }
        $page = new \vrklk\view\VPage(
            $this->response['title'],
            $main_element,
            $user_id,
            $this->response['page']
        );
        $page->show();
    }
}
