<?php

namespace vrklk\model\form;

class FormDAO  extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iFormDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getFormInfo(int $form_id): array
    {
        // make form info arrays for every form
        // return the one matching form_id
        

        // get the form info from the Forms table (still to be worked out)


        //=======================================================
        // these are in-progress notes for clarification & memory
        //=======================================================
        // data is taken from the form_elements table in SQL. This table has four columns:
            // -- id
            // -- form_id
            // -- name (of the element)
            // -- type (of the element)

        $elements_query = '
            SELECT name, type
            FROM form_elements
            WHERE form_id = :form_id;
        ';
        $parameters = ['form_id' => [$form_id, true]];
        $elements = $this->crud->selectAsPairs($elements_query, $parameters);
        $form_info['elements'] = $elements;

        return $form_info;
    }
}
