<?php

namespace vrklk\model\site;

class AgendaDAO extends \vrklk\base\model\BaseDAO implements
    \vrklk\model\interfaces\iAgendaDAO
{
    //=========================================================================
    // PUBLIC
    //=========================================================================
    public function getUpcomingEvents(int $amount): array
    {
        // Returns array of events, possibly EventInfo objects later
        return $this->crud->selectMore(
            "SELECT date, name, blurb"
                . " FROM agenda"
                . " ORDER BY date ASC"
                . " LIMIT :amount",
            [
                'amount' => [$amount, true],
            ],
        );
    }
}
