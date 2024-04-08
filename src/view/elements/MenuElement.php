<?php

namespace vrklk\view\elements;

class MenuElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
    // Standard Data:
    // site logo
    // links to possible pages
    // Variable Data:
    // menu items

    private \vrklk\view\collections\MenuCollection $item_collection;

    public function __construct(?int $user_id)
    {
        $this->item_collection = new \vrklk\view\collections\MenuCollection(
            \ManKind\ModelManager::getSiteDAO()->getMenuItems(boolval($user_id)),
            new \vrklk\view\factories\MenuItemFactory()
        );
    }

    public function show()
    {
        $home_link = \Config::LINKBASE . 'index.php';
        echo <<<EOD
        <div class="offcanvas offcanvas-top row gx-0" style="height:150px" id="main-menu">
            <div class="offcanvas-header col-lg-3 d-flex align-items-center my-auto">
                <a href="{$home_link}" class="mx-auto">
                <img src="./assets/img/verrukkulluk_logo.png" style="height:100px" alt="Logo homepage">
                </a>
            </div>
            <div class="offcanvas-body col-lg-9 d-flex flex-row-reverse">
                <nav class="navbar navbar-expand-sm">
                    <ul class="navbar-nav">
        EOD . PHP_EOL;

        $menu_items = $this->item_collection->getItems();
        if ($menu_items) {
            foreach ($menu_items as $menu_item) {
                $menu_item->show();
            }
        } else {
            echo <<<EOD
            <li class="nav-item px-3">
                <h1>Kan menu niet tonen</h1>
            </a></li>
            EOD . PHP_EOL;
        }

        echo <<<EOD
                    </ul>
                </nav>
            </div>
        </div>
        <div class="btn-menu-position">
            <button class="btn btn-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#main-menu">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        EOD . PHP_EOL;
    }
}
