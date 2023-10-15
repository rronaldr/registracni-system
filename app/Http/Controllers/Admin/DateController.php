<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DateFacade;
use App\Services\Admin\EventFacade;
use App\Services\EmailFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class DateController extends Controller
{
    public function getEventDates(int $id, DateFacade $dateFacade): JsonResponse
    {
        $dates = $dateFacade->getEventDates($id);

        return response()->json(['dates' => $dates], 200);
    }

    public function getDateEnrollments(int $id, DateFacade $dateFacade): JsonResponse
    {
        $enrollments = $dateFacade->getDateEnrollments($id);

        return response()->json($enrollments, 200);
    }

    public function store(int $id, Request $request, DateFacade $dateFacade, EventFacade $eventFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), $dateFacade->getDateValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $date = $dateFacade->createDate($id, $request->get('date'));
            $eventFacade->setEventDateCache($date->event->id);

            return response()->json(null, 204);
        } catch (Throwable $e) {
            dump($e);
        }
    }

    public function update(int $id, Request $request, DateFacade $dateFacade, EventFacade $eventFacade): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(),
                array_merge(['date.id' => 'required|numeric'], $dateFacade->getDateValidationRules()));

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $date = $dateFacade->updateDate($id, $request->get('date'));
            $eventFacade->setEventDateCache($date->event->id);

            return response()->json(null, 204);
        } catch (Throwable $e) {
            dump($e);
        }
    }

    public function destroy(int $id, Request $request,DateFacade $dateFacade, EventFacade $eventFacade, EmailFacade $emailFacade): JsonResponse
    {
        $date = $dateFacade->getDateById($id);
        $eventId = $date->event->id;

        // @todo Send email about signoff and block reason

        $dateFacade->removeDate($id);
        $eventFacade->setEventDateCache($eventId);

        return response()->json(null, 204);
    }

    public function signOffEnrollmentUser(int $id, Request $request, DateFacade $dateFacade): JsonResponse
    {
        /** @todo send email with localization of message */
        $blockReason = $request->get('data');
        $dateFacade->signOffUser($id);

        return response()->json(null, 204);
    }
}
