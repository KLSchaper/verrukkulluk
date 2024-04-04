<?php

namespace vrklk\model\site;

class SiteDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iDetailMenuDAO,
    \vrklk\model\interfaces\iFooterDAO,
    \vrklk\model\interfaces\iLoginDAO,
    \vrklk\model\interfaces\iMenuDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getDetailMenuItems(): array
    {
        return $this->crud->selectAsPairs(
            "SELECT value, display"
                . " FROM lookup AS l"
                . " WHERE l.group = 'detail_tabs'"
                . " ORDER BY id ASC"
        );
    }

    public function getFooterTitle(): string
    {
        return 'Contact';
    }

    public function getContactInfo(): array
    {
        return [
            'url'       => 'Verrukkulluk.nl',
            'street'    => 'Poststraat 2b',
            'city'      => 'Sittard',
            'email'     => 'info@verrukkulluk.nl'
        ];
    }

    public function getLoginTitle(bool $logged_user): string
    {
        return $logged_user ? 'Uitloggen' : 'Login';
    }

    public function getLoginContent(bool $logged_user): array
    {
        // return info to fill the login element depending on if a logged user
        // exists or not
        return [];
    }

    public function getMenuItems(bool $logged_user): array
    {
        $logged_in_menu = [
            'favorites'     => [
                'title'         => 'Mijn Favorieten',
                'type'          => 'link',
                'display_order' => 10,
            ],
            'add_recipe'    => [
                'title'         => 'Recept Toevoegen',
                'type'          => 'link',
                'display_order' => 20,
            ],
            'shopping_list' => [
                'title'         => 'Mijn Boodschappenlijst',
                'type'          => 'link',
                'display_order' => 30,
            ],
        ];
        $logged_out_menu = [
            'shopping_list' => [
                'title'         => 'Mijn Boodschappenlijst',
                'type'          => 'link',
                'display_order' => 30,
            ],
        ];
        return $logged_user ? $logged_in_menu : $logged_out_menu;
    }
}
