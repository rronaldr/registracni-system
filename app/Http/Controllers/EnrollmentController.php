<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EnrollmentStates;
use App\Models\Enrollment;
use App\Services\DateFacade;
use App\Services\EmailFacade;
use App\Services\EnrollmentFacade;
use App\Services\EventFacade;
use App\Services\UserFacade;
use Illuminate\Http\RedirectResponse;
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
        DateFacade $dateFacade,
        UserFacade $userFacade
    ) {
        $user = $userFacade->getCurrentUser();
        $date = $dateFacade->getDateById($dateId);

        if ($user->cannot('enroll', [Enrollment::class, $date]) && $user->cannot('substituteEnroll', [Enrollment::class, $date]) ) {
            Session::flash('message', __('app.enrollment.cannot_enroll'));

            return redirect()->route('events.index');
        }

        $fields = $eventFacade->getEventCustomFields($dateId);

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
    ) {
        $date = $dateFacade->getDateById($dateId);

        if (auth()->user()->cannot('enroll', [Enrollment::class, $date]) && auth()->user()->cannot('substituteEnroll', [Enrollment::class, $date])) {
            Session::flash('message', __('app.enrollment.already_exists'));

            return redirect()->route('events.index');
        }

        try {
            $event = $date->load('event')->event;
            $eventFields = $event->c_fields;

            $validator = Validator::make($request->get('data'),
                $enrollmentFacade->getValidationRulesForTags($eventFields));

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $enrollment = $enrollmentFacade->createEnrollment($dateId, $request);
            $emailFacade->sendUserEnrolledEmail($enrollment->id);

            if ($date->getSignedCount() === $date->capacity && $enrollment->state === EnrollmentStates::SIGNED) {
                $emailFacade->sendCapacityReachedEmail($date);
            }

            Session::flash('message', __('app.enrollment.enrolled_message'));

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

    public function signOff(int $id, EnrollmentFacade $enrollmentFacade): RedirectResponse
    {
        $enrollment = $enrollmentFacade->getEnrollmentById($id);

        if (auth()->user()->cannot('signOff',$enrollment)){
            Session::flash('message', __('app.enrollment.sign-off-error'));

            return redirect()->back();
        }

        $enrollmentFacade->signOffUser($enrollment);

        Session::flash('message', __('app.enrollment.signed-off'));

        return redirect()->back();
    }

    public function signSubstituteByEmail(int $id, string $email, EnrollmentFacade $enrollmentFacade): RedirectResponse
    {
        $enrolled = $enrollmentFacade->enrollUserByEmail($id, $email);

        if (!$enrolled) {
            Session::flash('message', __('app.enrollment.enroll-email-error'));

            return redirect()->route('events.index');
        }

        Session::flash('message', __('app.enrollment.enroll-email-success'));

        return redirect()->route('events.index');
    }
}
