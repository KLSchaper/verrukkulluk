<?php

namespace vrklk\view\elements;

class NameElement extends \vrklk\base\view\BaseElement
{
    private array $commentData;

    public function __construct(array $commentData)
    {
        $this->commentData = $commentData;
    }

    public function show()
    {
        //div: left
            // img: profile picture (from commentData['u.img'])
        //div: right
            // h: username (from commentData['u.name'])
            // p: comment (from commentData['c.text'])
    }
}