<?php

namespace App\Exports;

use App\Services\Admin\EventFacade;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersEmailExport implements FromCollection
{
    private int $eventId;
    private EventFacade $eventFacade;

    public function __construct($eventId, EventFacade $eventFacade)
    {
        $this->eventId = $eventId;
        $this->eventFacade = $eventFacade;
    }

    public function collection(): Collection
    {
        return $this->eventFacade->getEventUsersEmail($this->eventId);
    }
}
