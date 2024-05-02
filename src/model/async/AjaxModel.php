<?php

namespace vrklk\model\async;

use vrklk\base\controller\BaseAjaxFunction;

class AjaxModel extends \vrklk\base\model\BaseAsyncModel
{
    public function createResponse(string $request): BaseAjaxFunction
    {
        return new BaseAjaxFunction();
    }

    public function getErrors(): string
    {
        return 'Errors!';
    }
}