<?php
namespace vrklk\model\site;

class SiteDAO implements 
    \vrklk\model\interfaces\iDetailMenuDAO,
    \vrklk\model\interfaces\iFooterDAO,
    \vrklk\model\interfaces\iLoginDAO,
    \vrklk\model\interfaces\iMenuDAO
{
    public function getDetailMenuItems() : array
    {
        return ['Ingrediënten', 'Bereidingswijze', 'Opmerkingen'];
    }

    public function getFooterTitle() : string
    {
        return 'Contact';
    }

    public function getContactInfo() : array
    {
        return ['url'       => 'Verrukkulluk.nl',
                'street'    => 'Poststraat 2b',
                'city'      => 'Sittard',
                'email'     => 'info@verrukkulluk.nl'];
    }

    public function getLoginTitle(bool $logged_user) : string
    {
        return $logged_user ? 'Uitloggen' : 'Login';
    }

    public function getLoginContent(bool $logged_user) : array
    {
        // return info to fill the login element depending on if a logged user
        // exists or not
        return [];
    }

    public function getMenuItems(bool $logged_user) : array
    {
        $logged_in_menu = [
            'Mijn Favorieten', 
            'Recept Toevoegen', 
            'Mijn Boodschappenlijst'
        ];
        $logged_out_menu = ['Mijn Boodschappenlijst'];
        return $logged_user ? $logged_in_menu : $logged_out_menu;
    }
}