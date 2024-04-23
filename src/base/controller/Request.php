<?php

namespace vrklk\base\controller;

class Request
{
    protected $request;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct()
    {
        $this->getHandlerRequest();
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    //=========================================================================
    // PROTECED
    //=========================================================================
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

    protected function getHandlerRequest(): void
    {
        $posted = ($_SERVER['REQUEST_METHOD'] === 'POST');
        $this->request =
            [
                'posted'    => $posted,
                'handler'   => $this->getRequestVar('handler', $posted, 'page')
            ];
    }
}
