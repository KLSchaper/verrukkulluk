<?php

namespace vrklk\view\elements;

class SlideshowElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
    // Standard Data
        // images for the slideshow

    private array $slideshow_images;

    public function __construct()
    {
        // get the images for the carousel into $slideshow_images
    }

    public function show()
    {
        // div: class carousel-inner
        foreach ($this->slideshow_images as $slideshow_image) {
            // div: class carousel-item
            // img: slideshow_image
        }
    }
}
