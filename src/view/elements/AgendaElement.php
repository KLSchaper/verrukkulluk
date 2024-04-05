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
        $this->agenda_info = 
            \ManKind\ModelManager::getAgendaDAO()->getUpcomingEvents(5);
    }

    public function show()
    {
        echo <<<EOD
        <div class="d-flex flex-column agenda" id="agenda-block">
            <div class="text-center" style="color:var(--white)">
                <h1 class="lily">Agenda</h1>
            </div>
        EOD . PHP_EOL;
        foreach($this->agenda_info as $event) {
            $date = date_create($event['date']);
            echo <<<EOD
                    <div class="container row">
                        <div class="col-sm-3" style="color:var(--white)">
                            <h3>{$date->format('d/m')}</h3>
                            <p>{$date->format('H:i')}</p>
                        </div>
                        <div class="col-sm-9">
                            <h3 class="lily">{$event['name']}</h3>
                            <p>{$event['blurb']}</p>
                        </div>
                    </div>
            EOD . PHP_EOL;
        }
        echo <<<EOD
        </div>
        EOD . PHP_EOL;
    }
}