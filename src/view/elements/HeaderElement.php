<?php

namespace vrklk\view\elements;

class HeaderElement extends \vrklk\base\view\BaseElement
{
    private array $elements;
    private int $user_id;

    public function __construct(array $elements, ?int $user_id)
    {
        $this->elements = $elements;
        $this->user_id = $user_id;
    }
    
    public function show()
    {
        echo <<<EOD
        <header class="container">
        EOD . PHP_EOL;
        foreach ($this->elements as $element) {
            $element->show();
        }
        echo <<<EOD
        </header>
        EOD . PHP_EOL;
    }
}
