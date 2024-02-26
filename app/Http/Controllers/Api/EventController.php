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

    public function getEventDates(int $id, EventFacade $eventFacade, DateRepository $dateRepository): JsonResponse
    {
        /** @var \App\Models\Event $event */
        $event = $eventFacade->getEventByCalendarId($id);
        $event = $event ?? $eventFacade->getEventById($id);

        $dates = $dateRepository->getDatesByEventId($event->id)->transform(function (Date $date) {
            $date->enrolled_count = $date->getSignedCount();

            return $date;
        });

        return response()->json(['dates' => $dates]);
    }

    public function store(Request $request, EventFacade $eventFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), $eventFacade->getEventValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $eventFacade->createEvent($validator->validated());

            return response()->json(['success' => true]);
        } catch (InvalidXnameUser $e) {
            return response()->json(['error' => 'user with this xname doesnt exist'], 400);
        } catch (Throwable $e) {
            return response()->json(['error' => $e], 400);
        }
    }
}