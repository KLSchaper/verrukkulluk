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

    private \vrklk\model\site\SiteDAO $site_dao;
    private array $menu_items;

    public function __construct($user_id)
    {
        $this->site_dao = \ManKind\ModelManager::getSiteDAO();
        $this->menu_items = $this->site_dao->getMenuItems(boolval($user_id));
    }

    public function show()
    {
        echo <<<EOD
        <div class="offcanvas offcanvas-top row gx-0" style="height:150px" id="main-menu">
            <div class="offcanvas-header col-lg-3 d-flex align-items-center my-auto">
                <a href="#" class="mx-auto">
                <img src="./assets/img/verrukkulluk_logo.png" style="height:100px" alt="Logo homepage">
                </a>
            </div>
            <div class="offcanvas-body col-lg-9 d-flex flex-row-reverse">
                <nav class="navbar navbar-expand-sm">
                    <ul class="navbar-nav">
        EOD . PHP_EOL;

        foreach ($this->menu_items as $item) {
            echo <<<EOD
                            <li class="nav-item px-3">
                                <a class="nav-link" href="#">
                                <h1 class="lily">$item</h1>
                            </a></li>
            EOD . PHP_EOL;
        }

        echo <<<EOD
                    </ul>
                </nav>
            </div>
        </div>

        <button class="btn btn-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#main-menu">
        <i class="fa fa-bars"></i>
        </button>
        EOD . PHP_EOL;
    }
}
