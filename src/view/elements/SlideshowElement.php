<?php

namespace vrklk\view\elements;

class SlideshowElement extends \vrklk\base\view\BaseElement
{
    private array $slideshow_images;

    public function __construct()
    {
        $this->slideshow_images = [
            'Slide 0' => 'assets/img/slides/slide0.jpg',
            'Slide 1' => 'assets/img/slides/slide1.jpg',
            'Slide 2' => 'assets/img/slides/slide2.jpg',
            'Slide 3' => 'assets/img/slides/slide3.jpg',
            'Slide 4' => 'assets/img/slides/slide4.jpg',
        ];
    }

    public function show()
    {
        echo <<<EOD
        <div id="main-carousel" class="container carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
        EOD . PHP_EOL;
        for ($i = 0; $i < count($this->slideshow_images); $i++) {
            $i === 0 ? $class = ' class="active"' : $class = '';
            echo <<<EOD
                    <button type="button" data-bs-target="#main-carousel" data-bs-slide-to="{$i}"{$class}></button>
            EOD . PHP_EOL;
        }
        echo <<<EOD
            </div>
            <div class="carousel-inner">
        EOD . PHP_EOL;
        foreach ($this->slideshow_images as $alt => $src) {
            $alt === 'Slide 0' ? $class = ' active' : $class = '';
            echo <<<EOD
                    <div class="carousel-item{$class}">
                        <img src="{$src}" alt="{$alt}" class="d-block w-100 mx-auto">
                    </div>
            EOD . PHP_EOL;
        }
        echo <<<EOD
            </div>
        </div>
        EOD . PHP_EOL;
    }
}
