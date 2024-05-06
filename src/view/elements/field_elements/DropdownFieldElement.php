<?php

//TODO get this to work with variable dropdowns, without having to put them into a separate table.

namespace vrklk\view\elements\field_elements;

class DropdownFieldElement extends \vrklk\view\elements\field_elements\BaseFieldElement {
    private string $dropdown_options;

    public function __construct($field_id, $field_type, $layout_data, $controller_field_data)
    {
        parent::__construct($field_id, $field_type, $layout_data, $controller_field_data);
        $form_dao = \ManKind\ModelManager::getFormDAO();
        $dropdown_info = $form_dao->getDropdownInfo($field_id);
        $this->dropdown_options = '';
        foreach ($dropdown_info as $option) {
            if (isset($option['name'])) {
                $option['display'] = $option['name'];
                $option['value'] = $option['name'];
            }
            $this->dropdown_options .= '<option value="' . $option['value'];

            //TODO this was originally intended to keep selected options, but it doesn't work this way. Fix it.
            //if ($option['value'] == $this->field_info['value']) {
            //    $this->dropdown_options .= ' selected';
            //}
            $this->dropdown_options .= '">' . $option['display'] .'</option>';
        }
    }

    public function show()
    {
        $required = $this->field_info['required'] ? '*' : '';

        echo <<<EOD
        <div class = "{$this->layout_data['complete_layout_class']}">
            <div class = "{$this->layout_data['label_layout_class']}">
                <label class = "{$this->field_info['label_class']}" for = "{$this->field_info['name']}">
                    {$this->field_info['label']}
                </label>
            </div>

            <div class = "{$this->layout_data['input_layout_class']}">
                <select id = "{$this->field_info['name']}" name = "{$this->field_info['name']}" class = "{$this->field_info['input_class']}">
                {$this->dropdown_options}
                </select>
            </div>

            <div class = "{$this->layout_data['error_layout_class']}">
                <span class = "{$this->field_info['error_class']}">
                    $required
                    {$this->field_info['error']}
                </span>
            </div>
        </div>
        EOD;
    }
}