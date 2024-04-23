<?php

namespace vrklk\view\elements;

class MenuItemElement extends \vrklk\base\view\BaseElement
{
    private $name;
    private $title;
    private $display_order;

    public function __construct(
        string $name,
        string $title,
        int $display_order
    ) {
        $this->name = $name;
        $this->title = $title;
        $this->display_order = $display_order;
    }

    public function show()
    {
        $link = \Config::LINKBASE_PAGE . $this->name;
        echo <<<EOD
        <li class="nav-item px-3">
            <a class="nav-link" href="{$link}">
            <h1 class="lily">{$this->title}</h1>
        </a></li>
        EOD . PHP_EOL;
    }
}
