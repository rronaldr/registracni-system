<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Services\Admin\DateFacade;
use Illuminate\Http\JsonResponse;

class DateController extends Controller
{
    public function getEventDates(int $id, DateFacade $dateFacade): JsonResponse
    {
        $dates = $dateFacade->getEventDates($id);

        return response()->json(['dates' => $dates], 200);
    }

    public function update(int $id): void
    {

    }

    public function destroy(int $id): void
    {
        Date::destroy($id);
    }
}
