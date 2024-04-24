<?php

namespace vrklk\base\controller;

abstract class Request
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public static function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }
    
    public static function getRequestVar(
        string $key,
        mixed $default = "",
        bool $asnumber = FALSE
    ): mixed {
        $frompost = Request::isPost();
        $filter = $asnumber ? FILTER_SANITIZE_NUMBER_FLOAT : FILTER_UNSAFE_RAW;
        $result = filter_input(($frompost ? INPUT_POST : INPUT_GET),
            $key,
            $filter
        );
        if ($result === FALSE || $result === NULL) {
            $result = $default;
        } else {
            $result = $asnumber ? $result : htmlspecialchars($result);
        }
        return $result;
    }
}
