<?php

namespace vrklk\view\elements;

class LogElement extends \vrklk\base\view\BaseElement
{
    private int $user_id;
    private \vrklk\model\interfaces\iLoginDAO $dao;
    // This element needs:
    // Standard Data

    // Variable Data

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
            <div class="text-center" style="color:var(--white)">
                <h1 class="lily display-3">{$title}</h1>
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

    private function showLogoutContent($user_id)
    {
        // get username of user with matching user_id

        // content:
        // div:
            // h: username
            // button: logout
        // echo $content;
    }

    private function showLoginContent()
    {
        // get login form
        
        // content:
        //div:
            // form: loginform
            // button: link naar registration page

            // Still include form data
            $login_form = new \Vrklk\view\elements\FormElement(1, []);
            $login_form->show();
    }
}
