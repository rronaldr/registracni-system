<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Event\EventStatusEnum;
use App\Models\Date;
use App\Models\Enrollment;
use App\Services\DateFacade;
use App\Services\EventFacade;
use App\Services\UserFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{

    public function index(UserFacade $userFacade)
    {
        $userFacade->assignRolesToUserFromEntitlements();

        if (Session::has('iframe') && Session::get('iframe') === true) {
            Session::forget('iframe');

            return redirect()->route('iframe.login.success');
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

    public function showIframeDates(int $id, EventFacade $eventFacade): View
    {
        $event = $eventFacade->getEventById($id);
        $activeDates = $event->dates()->where('dates.enrollment_start', '<', now())
            ->where('dates.enrollment_end', '>', now())
            ->count();

        return view('event-iframe',[
            'event' => $event,
            'activeDates' => $activeDates
        ]);
    }

    public function getEventActiveDates(int $id, DateFacade $dateFacade): JsonResponse
    {
        $dates = $dateFacade->getActiveEventDates($id);

        if (auth()->check()) {
            $user = auth()->user();

            $dates->getCollection()->transform(function (Date $date) use ($user) {
                $enrollment = $date->enrollments()->where('user_id', $user->id)->first();
                $date->can_enroll = $user->can('enroll', [Enrollment::class, $date]) || $user->can('substituteEnroll',
                        [Enrollment::class, $date]);

                if ($enrollment !== null) {
                    $date->can_sign_off = $date->hasUserEnrolled($user->id) && $user->can('signOff',
                            [$enrollment]);
                    $date->enrollment_id = $enrollment->id;
                }

                return $date;
            });
        }

        return response()->json($dates);
    }
}
