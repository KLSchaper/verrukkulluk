<?php

namespace vrklk\view\elements;

class NameElement extends \vrklk\base\view\BaseElement
{
    private array $ingredientData;

    public function __construct(array $ingredientData)
    {
        $this->ingredientData = $ingredientData;
    }

    public function show()
    {
        //div: left
            //img: ingredient image (from ingredientData['img'])
        //div: right
            //h: ingredient name (from ingredientData['ingredient'])
            //p: ingredient description (from ingredientData['blurb'])
            //p: "hoeveelheid"
            //p: ingredient amount (from ingredientData['quantity'] & ingredientData['measure'])
    }
}