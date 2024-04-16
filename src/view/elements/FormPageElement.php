<?php

namespace vrklk\view\elements;

class FormPageElement extends \vrklk\base\view\BaseElement
{
    private string $title;
    private \vrklk\view\elements\FormElement $form;
    
    public function __construct(string $title, int $form_id, array $controller_form_data)
    {
        $this->title = $title;
        $this->form = new \vrklk\view\elements\FormElement($form_id, $controller_form_data);
    }

    public function show()
    {
        echo <<<EOD
        <div class = "my-4">
            <h1 class = "green-lily">
                {$this->title}
            </h1>
        EOD;

        $this->form->show();

        echo <<<EOD
        </div>
        EOD;

    }
}