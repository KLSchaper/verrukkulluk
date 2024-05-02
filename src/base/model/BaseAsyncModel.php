<?php

namespace vrklk\base\model;

use \vrklk\base\controller\BaseAjaxFunction;

abstract class BaseAsyncModel
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    abstract public function createResponse(string $request): BaseAjaxFunction;
    abstract public function getErrors(): string;
}
