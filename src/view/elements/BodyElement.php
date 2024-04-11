<?php

namespace vrklk\view\elements;

class BodyElement extends \vrklk\base\view\BaseElement
{
    private array $side_elements;
    private \vrklk\base\view\BaseElement $main_element;

    public function __construct(
        array $side_elements,
        \vrklk\base\view\BaseElement $main_element
    ) {
        $this->side_elements = $side_elements;
        $this->main_element = $main_element;
    }

    public function show()
    {
        echo <<<EOD
        <div class="container">
            <div class="row">
                <aside class="col-sm-4">
        EOD . PHP_EOL;
        foreach ($this->side_elements as $element) {
            $element->show();
        }
        echo <<<EOD
                </aside>
                <div class="col-sm-8 pt-2">
        EOD . PHP_EOL;

        $this->main_element->show();

        echo <<<EOD
                </div>
            </div>
        </div>
        EOD . PHP_EOL;
    }
}
