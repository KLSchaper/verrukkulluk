<?php

namespace vrklk\view\elements;

class AgendaElement extends \vrklk\base\view\BaseElement
{
    // This element needs:
    // Standard Data

    // Variable Data
        // agenda details for a number of entries

    private array $agenda_info;

    public function __construct()
    {
        // get the agenda details from the agendaDAO for the next number of entries, and store it in the $agenda_data
    }

    public function show()
    {
        // div:
            //h: "Agenda"
        foreach($this->agenda_info as $event) {
            //div:
                //h: entry name
                //p: entry date
                //p: entry description
        }
    }
}