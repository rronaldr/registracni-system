<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\DateFacade;
use App\Services\EmailFacade;
use App\Services\EnrollmentFacade;
use App\Services\EventFacade;
use App\Services\UserFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Throwable;

class EnrollmentController extends Controller
{
    public function show(
        int $dateId,
        EventFacade $eventFacade,
        EnrollmentFacade $enrollmentFacade,
        UserFacade $userFacade
    ) {
        $fields = $eventFacade->getEventCustomFields($dateId);

        $existingEnrollment = $enrollmentFacade->checkExistingEnrollment($dateId, $userFacade->getCurrentUser()->id);
        if ($existingEnrollment) {
            Session::flash('message', __('app.enrollment.already_exists'));

            return redirect()->route('events.index');
        }

        return view('enrollment', [
            'dateId' => $dateId,
            'fields' => collect($fields->c_fields)->sortBy('id')->values()
        ]);
    }

    public function store(
        int $dateId,
        Request $request,
        EnrollmentFacade $enrollmentFacade,
        DateFacade $dateFacade,
        EmailFacade $emailFacade
    ): JsonResponse {
        try {
            $date = $dateFacade->getDateById($dateId);
            $event = $date->load('event')->event;
            $eventFields = $event->c_fields;
            $eventId = $event->id;

            $validator = Validator::make($request->get('data'),
                $enrollmentFacade->getValidationRulesForTags($eventFields));

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $enrollmentId = $enrollmentFacade->createEnrollment($dateId, $request);

            $emailFacade->sendUserEnrolledEmail($enrollmentId);

            if ($date->getSignedCount() === $date->capacity) {
                $emailFacade->sendCapacityReachedEmail($date);
            }

            return response()->json(null, 204);
        } catch (Throwable $e) {
            dump($e);
        }
    }

    public function getUserEnrollments(int $id, EnrollmentFacade $enrollmentFacade): view
    {
        $enrollments = $enrollmentFacade->getEnrollmentsForUser($id);

        return view('enrollment-user', [
            'enrollments' => $enrollments
        ]);
    }
}
