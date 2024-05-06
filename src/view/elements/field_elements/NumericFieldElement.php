<?php

namespace vrklk\view\elements\field_elements;

class NumericFieldElement extends \vrklk\view\elements\field_elements\BaseFieldElement {

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
                <input class = "{$this->field_info['input_class']}" type = "number"
                id = "{$this->field_info['name']}" name = "{$this->field_info['name']}" value = "{$this->field_info['value']}"
                min = "{$this->field_info['min_value']}" max = "{$this->field_info['max_value']}">
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