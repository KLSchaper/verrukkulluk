<?php

namespace vrklk\view\elements;

class MenuElement extends BaseElement
{
    // This element needs:
    // Standard Data:
        // site logo
        // links to possible pages
    // Variable Data:
        // menu items

    private BaseDAO $site_dao;
    private array $menu_items;

    public function __construct($user_id)
    {
        // Initialize DAOs required:
        // -- SiteDAO

        $this->menu_items = $this->site_dao->getMenuItems(boolval($user_id));
    }

    public function show()
    {
        // link: img: verrukkulluk logo
        // for each menu item: span (?): menuitem.
    }

}
