<?php

namespace vrklk\view\elements;

class FormElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
    // Standard Data

    // Variable Data

    private array $elements;
    private array $form_info;

    public function __construct($form_id)
    {
        $form_dao = \ManKind\ModelManager::getFormDAO();
        $this->form_info = $form_dao->getFormInfo($form_id);
        $this->elements = $this->form_info['elements'];
    }

    public function show()
    {
        // this will be replaced with a new binary tree creation, but it's the same principle.
        foreach ($this->elements as $element_name => $element_type) {
            $class_name = '\vrklk\view\elements\form_elements\\' . $element_type . 'Element';
            $element = new $class_name($element_name);
            $element->show();
        }
    }
}