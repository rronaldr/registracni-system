<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\InvalidXnameUser;
use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Repositories\DateRepository;
use App\Services\Api\EventFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class EventController extends Controller
{

    public function getEventDates(int $id, Request $request, EventFacade $eventFacade, DateRepository $dateRepository): JsonResponse
    {
        try {
            if ($request->has('type') && in_array($request->get('type'), ['calendar', 'id'])) {
                /** @var \App\Models\Event $event */
                $event = $request->get('type') === 'calendar'
                    ? $eventFacade->getEventByCalendarId($id)
                    : $eventFacade->getEventById($id);
            } else {
                /** @var \App\Models\Event $event */
                $event = $eventFacade->getEventById($id);
            }

            $dates = $dateRepository->getDatesByEventId($event->id)->transform(function (Date $date) {
                $date->enrolled_count = $date->getSignedCount();

                return $date;
            });
            return response()->json(['dates' => $dates]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage(), 404]);
        }
    }

    public function store(Request $request, EventFacade $eventFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), $eventFacade->getEventValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $id = $eventFacade->createEvent($validator->validated());

            return response()->json(['id' => $id]);
        } catch (InvalidXnameUser $e) {
            return response()->json(['error' => 'user with this xname doesnt exist'], 400);
        } catch (Throwable $e) {
            return response()->json(['error' => $e], 400);
        }
    }
}