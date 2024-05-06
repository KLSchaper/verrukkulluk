<?php

namespace vrklk\view\elements\field_elements;

class BaseFieldElement extends \vrklk\base\view\BaseElement
{

    protected array $field_info;
    protected array $layout_data;

    public function __construct($field_id, $field_type, $layout_data, $controller_field_data)
    {
        $form_dao = \ManKind\ModelManager::getFormDAO();
        $this->field_info = $form_dao->getFieldInfo($field_id, $field_type);
        $this->layout_data = $layout_data;

        if ($controller_field_data['value']) {
            $this->field_info['value'] = $controller_field_data['value'];
        }

        $this->field_info['error'] = $controller_field_data['error'];
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
                <input class = "{$this->field_info['input_class']}" type = "{$this->field_info['type']}"
                id = "{$this->field_info['name']}" name = "{$this->field_info['name']}" value = "{$this->field_info['value']}">
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