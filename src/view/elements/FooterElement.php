<?php

namespace vrklk\view\elements;

class FooterElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
        //verrukkulluk image
        //footer title
        //contact text

    private string $footer_title;
    private array $contact_info;

    public function __construct()
    {
        $this->footer_title = \ManKind\ModelManager::getSiteDAO()->getFooterTitle();
        $this->contact_info = \ManKind\ModelManager::getSiteDAO()->getContactInfo();
    }

    public function show()
    {
        //div:
            //img: verrukkulluk logo
            //h: footer title
            //p: contact info
        echo <<<EOD
        <footer class="footer-custom" id="footer">
            <div class="row">
                <div class="col-sm-3">
                    <img src="./assets/img/verrukkulluk_logo.png" class="m-5" style="height:100px" alt="Logo footer">
                </div>
                <div class="col-sm-9" style="color:var(--white)">
                    <h1 class="lily display-3 m-3">{$this->footer_title}</h1>
                    <p class="my-0 mx-3">{$this->contact_info['url']}</p>
                    <p class="my-0 mx-3">{$this->contact_info['street']}</p>
                    <p class="my-0 mx-3">{$this->contact_info['city']}</p>
                    <p class="my-0 mx-3">{$this->contact_info['email']}</p>
                </div>
            </div>
        </footer>
        EOD . PHP_EOL;
    }
}