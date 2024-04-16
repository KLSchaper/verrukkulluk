<?php

namespace vrklk\view\elements;

class FormElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
    // Standard Data

    // Variable Data

    private array $field_elements;
    private array $form_info;

    public function __construct(int $form_id, array $controller_form_data)
    {
        $form_dao = \ManKind\ModelManager::getFormDAO();
        $this->form_info = $form_dao->getFormInfo($form_id);

        $this->field_elements = [];
        foreach ($this->form_info['fields'] as $field_id => $field_type) {
            $controller_field_data['value'] = isset($controller_form_data['form_values'][strval($field_id)]) ? $controller_form_data['form_values'][strval($field_id)] : '';
            $controller_field_data['error'] = isset($controller_form_data['form_errors'][strval($field_id)]) ? $controller_form_data['form_errors'][strval($field_id)] : '';

            $class_name = '\vrklk\view\elements\field_elements\\' . ucfirst($field_type) . 'FieldElement';
            $element = new $class_name($field_id, $field_type, $this->form_info['field_layout'], $controller_field_data);
            $this->field_elements[strval($field_id)] = $element;
        }
    }

    public function show()
    {
        // open form
        echo <<<EOD
        <form action = "{$this->form_info['action']}" method = "{$this->form_info['method']}"
        class = "{$this->form_info['classes']}" attributes = "{$this->form_info['attributes']}">
        EOD;

        // display fields
        foreach ($this->field_elements as $field) {
            $field->show();
        }

        // close form
        if ($this->form_info['submit_text']) {
            echo <<<EOD
                <input type = "submit" class = "{$this->form_info['submit_class']}" value = "{$this->form_info['submit_text']}">
            EOD;
        }
        
        echo <<<EOD
        </form>
        EOD;
    }
}