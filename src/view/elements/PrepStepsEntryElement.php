<?php

namespace vrklk\view\elements;

class NameElement extends BaseElement
{
    private array $stepData;

    public function __construct(array $stepData)
    {
        $this->stepData = $stepData;
    }

    public function show()
    {
        //div: left
            //img: background circle
            //h: step number (from stepData['number']. '.';)
        //div: right
            //p: step text (from stepData['descr'])
    }
}