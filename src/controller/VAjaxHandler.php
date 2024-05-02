<?php

namespace vrklk\controller;

use \vrklk\model\async\AjaxModel;

class VAjaxHandler extends \vrklk\base\controller\BaseAjaxHandler
{
    protected function _createAsyncModel(): \vrklk\base\model\BaseAsyncModel
    {
        return new AjaxModel;
    }
}
