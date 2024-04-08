<?php

namespace vrklk\view\elements;

class HeaderElement extends \vrklk\base\view\BaseElement
{
    private array $elements;

    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }
    
    public function show()
    {
        $home_link = \Config::LINKBASE . 'index.php';
        echo <<<EOD
        <header class="container" style="position:relative">
        <div class="header-logo">
            <a href="{$home_link}" class="mx-auto">
            <img src="./assets/img/verrukkulluk_logo.png" style="height:120px" alt="Logo homepage">
            </a>
        </div>
        EOD . PHP_EOL;
        foreach ($this->elements as $element) {
            $element->show();
        }
        echo <<<EOD
        </header>
        EOD . PHP_EOL;
    }
}
