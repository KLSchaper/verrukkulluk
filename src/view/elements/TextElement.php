<?php

namespace vrklk\view\elements;

class TextElement extends \vrklk\base\view\BaseElement
{
    private $text;
    private $title;

    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct(string $text, string $title='') {
        $this->text = $text;
        $title 
            ? $this->title = "<div><h1>{$title}</h1></div>" 
            : $this->title = "<!-- no title -->";
    }
    
    public function show()
    {
        echo <<<EOD
        <div class="text-center">
            {$this->title}
            <div><p>{$this->text}</p></div>
        </div>
        EOD . PHP_EOL;
    }
}
