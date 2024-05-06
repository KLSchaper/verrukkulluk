<?php

namespace vrklk\view\elements\field_elements;

class TextareaFieldElement extends \vrklk\view\elements\field_elements\BaseFieldElement {
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
                <textarea class = "{$this->field_info['input_class']}" id = "{$this->field_info['name']}"
                name = "{$this->field_info['name']}">{$this->field_info['value']}</textarea>
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