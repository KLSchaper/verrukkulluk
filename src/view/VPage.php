<?php

namespace vrklk\view;

class VPage extends \vrklk\base\view\HtmlDoc
{
    protected $main_element;
    protected $user_id;
    
    protected string $page;
    
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function __construct(
        string $title,
        \vrklk\base\view\BaseElement $main_element,
        int $user_id,
        string $page
    ) {
        parent::__construct($title, \Config::AUTHOR);
        $this->main_element = $main_element;
        $this->user_id = $user_id;
        $this->page = $page;
    }

    //=========================================================================
    // PROTECTED
    //=========================================================================
    protected function showHeadContent(): void
    {
        echo <<<EOD
        <title>$this->title</title>
        <meta name="author" content="$this->author">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/custom.css">
        <link rel="stylesheet" href="./assets/css/dialogs.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/83ed522242.js" crossorigin="anonymous"></script>
        EOD;
    }

    protected function showBodyContent(): void
    {
        $header = new \vrklk\view\elements\HeaderElement([
            new \vrklk\view\elements\SlideshowElement(),
            new \vrklk\view\elements\MenuElement($this->user_id),
            new \vrklk\view\elements\FormElement(3, [], $this->page)
        ]);
        $header->show();
        $content = new \vrklk\view\elements\BodyElement(
            [
                new \vrklk\view\elements\AgendaElement(),
                new \vrklk\view\elements\LogElement($this->user_id, $this->page)
            ],
            $this->main_element,
        );
        $content->show();
        $footer = new \vrklk\view\elements\FooterElement();
        $footer->show();
        echo <<<EOD
        <!-- BEGIN class GWDialog JS Component Html -->
        <div id="gw-dlg-overlay"></div>
        <div id="gw-dlg-box"> 
            <div id="gw-dlg-box-head">
                <img alt="logo" id="gw-dlg-logo" src="./assets/img/verrukkulluk_logo.png" />
                <div id="gw-dlg-box-title"></div>
            </div>
            <div id="gw-dlg-box-body"></div>
            <div id="gw-dlg-box-foot">
                <button id="gw-dlg-btn-ok" class="btn btn-success">OK</button>
                <button id="gw-dlg-btn-cancel" class="btn btn-default">Cancel</button>
            </div>
        </div>
        <!-- END class GWDialog JS Component Html -->
        <script src="./assets/js/gw_dialog.js"></script>
        <script src="./assets/js/dialogs.js"></script>
        <script src="./assets/js/ajax_functions.js"></script>
        EOD;
    }
}
