<?php

namespace vrklk\view\elements\field_elements;

class SearchFieldElement extends \vrklk\view\elements\field_elements\BaseFieldElement {

    //TODO find out why the magnifying glass doesn't appear
    public function show()
    {
        $required = $this->field_info['required'] ? '*' : '';

        echo <<<EOD
        <div class = "{$this->layout_data['complete_layout_class']}">
            <div class = "{$this->layout_data['input_layout_class']}">
                <div class = "input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    <input class = "{$this->field_info['input_class']}" type = "text"
                    id = "{$this->field_info['name']}" name = "{$this->field_info['name']}" value = "{$this->field_info['value']}">
                </div>
            </div>
        </div>
        EOD;
    }

}