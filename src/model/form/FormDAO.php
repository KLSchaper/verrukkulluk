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
        

        //=======================================================
        // these are in-progress notes for clarification & memory
        //=======================================================

        // data for the form is taken from the forms table in SQL. This table has the following columns:
            // -- id
            // -- name
            // -- method
            // -- action
            // -- classes
            // -- attributes
            // -- submit_text
            // -- label_column_class
            // -- input_column_class
            // -- error_column_class
            // -- row_class
        $parameters = ['form_id' => [$form_id, true]];

        $form_info_query = '
            SELECT name, action, method, classes, attributes, submit_text
            FROM forms
            WHERE id = :form_id;
        ';
        $form_info = $this->crud->selectOne($form_info_query, $parameters);

        $field_layout_query = '
            SELECT label_layout_class, input_layout_class, error_layout_class, complete_layout_class
            FROM forms
            WHERE id = :form_id;
        ';
        $form_info['field_layout'] = $this->crud->selectOne($field_layout_query, $parameters);

        // data for the fields is taken from the form_fields table in SQL. This table has the following columns:
            // -- id
            // -- form_id
            // -- name (of the field)
            // -- type (of the field)
            // -- label
            // -- required
            // -- label_class
            // -- input_class
            // -- error_class
            // -- value
            // -- validation

        $fields_query = '
            SELECT id, type
            FROM fields
            WHERE form_id = :form_id;
        ';
        $fields = $this->crud->selectAsPairs($fields_query, $parameters);
        $form_info['fields'] = $fields;

        return $form_info;
    }

    public function getFieldInfo($field_id, $field_type): array
    {
        switch ($field_type) {
            case '':
                // specific cases
                break;
            default:
                $field_info_query = '
                    SELECT name, label, type, label_class, input_class, error_class, required, value
                    FROM fields
                    WHERE id = :field_id;
                ';
        }
        
        $parameters = ['field_id'=> [$field_id, true]];
        $field_info = $this->crud->selectOne($field_info_query, $parameters);

        return $field_info;
    }
}
