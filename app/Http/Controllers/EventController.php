<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Event\EventStatusEnum;
use App\Models\Date;
use App\Models\Enrollment;
use App\Services\EventFacade;
use App\Services\UserFacade;
use Illuminate\View\View;

class EventController extends Controller
{

    public function index(UserFacade $userFacade): view
    {
        $userFacade->assignRolesToUserFromEntitlements();

        return view('events');
    }

    public function getEvents(EventFacade $eventFacade)
    {
        $events = $eventFacade->getPublishedEventsWithActiveDates();

        return response()->json($events);
    }

    public function show(int $id, EventFacade $eventFacade)
    {
        $event = $eventFacade->getEventByIdForDetailPage($id);

        if (!isset($event) || $event->status !== EventStatusEnum::PUBLISHED) {
            return redirect()->route('events.index');
        }

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
