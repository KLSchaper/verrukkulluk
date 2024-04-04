<?php

namespace vrklk\view\elements;

class NameElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
    // Standard Data

    // Variable Data

    // active tab is either Comments, Ingredients, or PrepSteps
    private string $tab_name;
    private int $user_id;
    private array $tab_content;
    private string $active_tab;

    public function __construct(string $active_tab, int $user_id)
    {
        $this->user_id = $user_id;
        $this->active_tab = $active_tab;

        // initiate DAO: $active_tab . "TabDAO"
        // call getTabContent, and store it in $tab_content
        // call getTabName, and store it in $tab_name
    }

    public function show()
    {
        // store tab names as $tabs from siteDAO: getDetailMenuItems

        // div:
        foreach ($tabs as $tab) {
            if ($tab == $this->tab_name) {
                //span: tabname (active)
            } else {
                //span: tabname (inactive)
            }
        }

        //div:
        foreach ($this->tab_content as $entry) {
            $entry_element = '\vrklk\view\elements\\' . $this->active_tab . 'EntryElement';
            $tab_sub_element = new $entry_element($entry);
            $tab_sub_element->show();
        }
        //div:
        if ($this->active_tab == "Comments" && $this->user_id > 0) {
            // form: comment form
        }
    }
}