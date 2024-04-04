<?php

namespace vrklk\view\elements;

class LogElement extends \vrklk\base\view\BaseElement
{
    private int $user_id;
    // This element needs:
    // Standard Data

    // Variable Data

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function show()
    {
        if ($this->user_id > 0) {
            $this->showLogoutMenu($this->user_id);
        } else {
            $this->showLoginMenu();
        }
    }

    private function showLogoutMenu($user_id)
    {
        // get username of user with matching user_id

        // content:
        // div:
            // h: username
            // button: logout
        // echo $content;
    }

    private function showLoginMenu()
    {
        // get login form
        
        // content:
        //div:
            // h: "login"
            // form: loginform
            // button: link naar registration page
    }
}
