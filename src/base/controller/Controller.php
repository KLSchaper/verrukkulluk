<?php

namespace vrklk\base\controller;

class Controller
{
    protected $request;
    protected $response;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function handleRequest(): void
    {
        $this->getRequest();
        $this->validateRequest();
        $this->showResponse();
    }

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function validateGet(): void
    {
        switch ($this->request['page']) {
                // needs to be extended
        }
    }

    protected function validatePost(): void
    {
        switch ($this->request['page']) {
                // needs to be extended
        }
    }

    protected function showResponse(): void
    {
        switch ($this->response['page']) {
                // needs to be extended
        }
    }

    protected function validateGeneral(): void
    {
        
    }

    protected function getRequestVar(
        string $key,
        bool $frompost,
        mixed $default = "",
        bool $asnumber = FALSE
    ): mixed {
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_UNSAFE_RAW;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET),
            $key,
            $filter
        );
        $result = $asnumber ? $result : htmlspecialchars($result);
        return ($result === FALSE || $result === NULL) ? $default : $result;
    }

    //=========================================================================
    // PRIVATE
    //=========================================================================
    private function getRequest(): void
    {
        $posted = ($_SERVER['REQUEST_METHOD'] === 'POST');
        $this->request =
            [
                'posted'    => $posted,
                'page'      => $this->getRequestVar('page', $posted, 'home')
            ];
    }

    private function validateRequest(): void
    {
        $this->response = $this->request;
        if ($this->request['posted']) {
            $this->validatePost();
        } else {
            $this->validateGet();
        }
        $this->validateGeneral();
    }
}
