<?php

namespace vrklk\view\elements;

class BodyElement extends \vrklk\base\view\BaseElement
{
    private array $elements;

    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public function show()
    {
        echo <<<EOD
        <div class="container" style="position:relative">
        EOD . PHP_EOL;
        foreach ($this->elements as $element) {
            $element->show();
        }
        echo <<<EOD
        </div>
        EOD . PHP_EOL;
    }
}
