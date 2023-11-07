<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Date;
use App\Models\Enrollment;
use App\Services\EventFacade;
use App\Services\UserFacade;
use Carbon\Carbon;
use Illuminate\View\View;

class EventController extends Controller
{

    public function index(EventFacade $eventFacade, UserFacade $userFacade): view
    {
        $userFacade->assignRolesToUserFromEntitlements();

        $date = Carbon::now()->startOfMonth();
        $events = $eventFacade->getPublishedEventsWithDatesInMonth($date);

        return view('events', [
            'events' => $events
        ]);
    }

    public function show(int $id, EventFacade $eventFacade): view
    {
        $event = $eventFacade->getEventByIdForDetailPage($id);

        if (auth()->check()) {
            $user = auth()->user();
            $event->dates = collect($event->dates)->map(function (Date $date) use ($user) {
                $date->can_enroll = $user->can('enroll',[Enrollment::class, $date]) || $user->can('substituteEnroll', [Enrollment::class, $date]);
                return $date;
            });
        }

        return view('event-detail', [
            'event' => $event
        ]);
    }
}
