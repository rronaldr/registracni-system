<?php

namespace App\Exports;

use App\Services\Admin\EventFacade;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class EventExport implements FromView, WithColumnWidths
{
    private int $eventId;
    private EventFacade $eventFacade;

    public function __construct($eventId, EventFacade $eventFacade)
    {
        $this->eventId = $eventId;
        $this->eventFacade = $eventFacade;
    }

    public function view(): view
    {
        $event = $this->eventFacade->getEventForExportById($this->eventId);

        return view('exports.event', [
            'event' => $event,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 15,
            'D' => 20,
            'E' => 20,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 10,
            'K' => 10,
        ];
    }
}
