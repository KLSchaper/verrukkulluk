<?php

namespace vrklk\model\form;

class FormDAO  extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iFormDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getFormInfo(int $form_id): array|false
    {
        // make form info arrays for every form
        // return the one matching form_id
        return [];
    }
}
