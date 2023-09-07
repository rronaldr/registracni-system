<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\EventFacade;
use Carbon\Carbon;
use Illuminate\View\View;

class EventController extends Controller
{

    public function index(EventFacade $eventFacade): view
    {
        $date = Carbon::now()->startOfMonth();
        $events = $eventFacade->getEventsWithDatesInMonth($date);

        return view('events',[
            'events' => $events
        ]);
    }

    public function show(int $id, EventFacade $eventFacade): view
    {
        $event = $eventFacade->getEventByIdForDetailPage($id);

        return view('event-detail', [
            'event' => $event
        ]);
    }
}