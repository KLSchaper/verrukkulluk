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
            case 'numeric':
                $field_info_query = '
                    SELECT name, label, type, label_class, input_class, error_class, required, value, min_value, max_value
                    FROM fields f
                    INNER JOIN fields_numeric f_n ON f_n.field_id = f.id
                    WHERE id = :field_id;
                ';
                break;
            case 'comment':
                $field_info_query = '
                    SELECT name, type, text
                    FROM fields f
                    INNER JOIN fields_comments f_c ON f_c.field_id = f.id
                    WHERE id = :field_id;
                ';
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

    public function getDropdownInfo($field_id): array
    {
        switch($field_id) {
            case 7:
                // still needs to be grouped and ordered by category.
                $dropdown_query = '
                    SELECT `name`
                    FROM `cuisines`;
                ';
                break;
            case 8:
                $dropdown_query = '
                    SELECT `value`, `display`
                    FROM `lookup`
                    WHERE `group` = "recipe_types";
                ';
                break;
            case 13:
                $dropdown_query = '
                    SELECT `name`
                    FROM `ingredients`;
                ';
                break;
            case 15:
                // This needs to be replaced with measures based on ingredients, but that can only be done using AJAX
                // The current solution just gets all measures, but is a temporary replacement.
                $dropdown_query = '
                    SELECT `name`
                    FROM `measures`;
                ';
                break;
            case 26:
                $dropdown_query = '
                    SELECT `name`
                    FROM `measures`
                    WHERE `id` IN (1, 3, 5);
                ';
                break;
            default:
                $dropdown_query = '';
        }

        $parameters = [];
        $dropdown_info = $this->crud->selectMore($dropdown_query, $parameters);
        return $dropdown_info;
    }
}
