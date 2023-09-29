<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Services\Admin\DateFacade;
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

    public function store(int $id, Request $request, DateFacade $dateFacade)
    {
        try {
            $validator = Validator::make($request->all(), $dateFacade->getDateValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $dateFacade->createDate($id, $request->get('date'));

            return response()->noContent();
        } catch (Throwable $e) {
            dump($e);
        }
    }

    public function update(int $id, Request $request, DateFacade $dateFacade)
    {
        try {
            $validator = Validator::make($request->all(), array_merge(['date.id' => 'required|numeric'], $dateFacade->getDateValidationRules()));

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $dateFacade->updateDate($id, $request->get('date'));

            return response()->noContent();
        } catch (Throwable $e) {
            dump($e);
        }
    }

    public function destroy(int $id): void
    {
        Date::destroy($id);
    }
}
