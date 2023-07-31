<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\EventFacade;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function show(int $id, EventFacade $eventFacade): view
    {
        $fields = $eventFacade->getEventCustomFields($id);

        return view('enrollment', [
            'fields' => $fields
        ]);
    }
}
