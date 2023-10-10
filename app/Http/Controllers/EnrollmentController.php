<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\EnrollmentFacade;
use App\Services\EventFacade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function show(int $dateId, EventFacade $eventFacade): view
    {
        $fields = $eventFacade->getEventCustomFields($dateId);

        return view('enrollment', [
            'dateId' => $dateId,
            'fields' => collect($fields->c_fields)
        ]);
    }

    public function store(int $dateId, Request $request, EnrollmentFacade $enrollmentFacade): RedirectResponse
    {
        $enrollmentFacade->createEnrollment($dateId, $request);

        return redirect()->route('enrollemnt.show', $dateId);
    }
}
