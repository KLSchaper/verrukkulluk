<?php

namespace vrklk\view\elements;

class LogElement extends \vrklk\base\view\BaseElement
{
    private int $user_id;
    private \vrklk\model\interfaces\iLoginDAO $dao;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
        $this->dao = \ManKind\ModelManager::getSiteDAO();
    }

    public function show()
    {
        $title = $this->dao->getLoginTitle(boolval($this->user_id));
        echo <<<EOD
        <div class="log-block m-4" id="log-block">
            <div class="text-center">
                <h1 class="white-lily display-3">{$title}</h1>
            </div>
        EOD . PHP_EOL;
        if ($this->user_id) {
            $this->showLogoutContent($this->user_id);
        } else {
            $this->showLoginContent();
        }
        echo <<<EOD
        </div>
        EOD . PHP_EOL;
    }

    private function showLogoutContent(int $user_id)
    {
        $name = \ManKind\ModelManager::getUsersDAO()->getUserById($user_id)['name'];
        $log_out_link = \Config::LINKBASE . 'index.php?page=log_out';
        echo <<<EOD
        <div class="text-center my-4">
            <p style="color: var(--white)">Ingelogd als {$name}</p>
        </div>
        <a href="{$log_out_link}" class="btn submit-logout p-0">
            <h1 class="white-lily m-0">Log uit</h1>
        </a>
        EOD . PHP_EOL;
    }

    private function showLoginContent()
    {
        $login_form = new \Vrklk\view\elements\FormElement(1, []);
        $login_form->show();
    }
}
