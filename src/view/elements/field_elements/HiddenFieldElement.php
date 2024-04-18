<?php

namespace vrklk\view\elements\field_elements;

class HiddenFieldElement extends \vrklk\view\elements\field_elements\BaseFieldElement {
    
    public function show()
    {
        echo <<<EOD
        <input type = "hidden" id = "{$this->field_info['name']}" name = "{$this->field_info['name']}" value = "{$this->field_info['value']}">
        EOD;
    }
}