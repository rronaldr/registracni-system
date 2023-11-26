<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Event\EventStatusEnum;
use App\Models\Date;
use App\Models\Enrollment;
use App\Services\DateFacade;
use App\Services\EventFacade;
use App\Services\UserFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{

    public function index(UserFacade $userFacade)
    {
        $userFacade->assignRolesToUserFromEntitlements();

        if (Session::has('iframe') && Session::get('iframe') === true) {
            Session::forget('iframe');

            return redirect()->intended();
        }

        return view('events');
    }

    public function getEvents(EventFacade $eventFacade): JsonResponse
    {
        $events = $eventFacade->getPublishedEventsWithActiveDates();

        return response()->json($events);
    }

    public function show(int $id, EventFacade $eventFacade, DateFacade $dateFacade)
    {
        $event = $eventFacade->getEventByIdForDetailPage($id);

        if (!isset($event) || $event->status !== EventStatusEnum::PUBLISHED) {
            return redirect()->route('events.index');
        }

        return view('event-detail', [
            'event' => $event
        ]);
    }

    public function getEventActiveDates(int $id, DateFacade $dateFacade): JsonResponse
    {
        $dates = $dateFacade->getActiveEventDates($id);

        if (auth()->check()) {
            $user = auth()->user();
            $dates->getCollection()->transform(function (Date $date) use ($user) {
                $date->can_enroll = $user->can('enroll',[Enrollment::class, $date]) || $user->can('substituteEnroll', [Enrollment::class, $date]);
                return $date;
            });
        }

        return response()->json($dates);
    }
}
