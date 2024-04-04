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
        //get footer data (site_dao->getFooterTitle, site_dao->getContactInfo)
    }

    public function show()
    {
        //div:
            //img: verrukkulluk logo
            //h: footer title
            //p: contact info
    }
}