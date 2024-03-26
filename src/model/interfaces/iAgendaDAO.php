<?php
namespace vrklk\model\interfaces;

interface iAgendaDAO
{
    public function getUpcomingEvents(int $amount): array;
}