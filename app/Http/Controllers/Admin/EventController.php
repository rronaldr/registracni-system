<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\Admin\EventFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EventController extends Controller
{
    public function index(EventFacade $eventFacade): View
    {
        $events = $eventFacade->getEventsForOverviewPaginated();

        return view('admin.events', [
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        return view('admin.event-create');
    }

    public function store(Request $request, EventFacade $eventFacade)
    {
        try {
            $validator = Validator::make($request->all(), $eventFacade->getValidationRules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $eventFacade->createEvent($request);

            Session::flash('message', __('app.event.saved'));

            return response()->noContent();
        } catch (\Exception $e) {
            dump($e);
        }
    }

    public function show(string $id): View
    {
        return view('admin.event-detail');
    }

    public function edit(string $id, EventFacade $eventFacade): View
    {
        $event = $eventFacade->getEventById((int) $id);

        return view('admin.event-edit', [
            'event' => $event,
        ]);
    }

    public function update(string $id, Request $request): View
    {
        return view('admin.event-form');
    }

    public function destroy(Event $event, EventFacade $eventFacade): RedirectResponse
    {
        try {
            $eventFacade->deleteEvent($event);
        } catch (\Exception $e){
            dump($e);
        }

        Session::flash('message', __('app.event.deleted'));

        return redirect()->route('admin.events');
    }

    /* @todo REDO this with VUE and json response */
    public function duplicate(Event $event, EventFacade $eventFacade): RedirectResponse
    {
        try {
            $newEvent = $eventFacade->duplicateEvent($event);

            return redirect()->route('admin.events.edit', [
                'id' => $newEvent->id,
            ]);
        } catch (\Exception $e){
            Session::flash('error', trans('event.duplication_error'));
        }

        Session::flash('message', trans('event.duplicated'));

        return redirect()->route('admin.events');
    }

    public function getEventDates(int $id, EventFacade $eventFacade): JsonResponse
    {
        try {
            $dates = $eventFacade->getEventWithStartAndEndDates($id);
            return response()->json($dates);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => trans('An error occurred.')]);
        }
    }

    public function getEventEnrollmentsUsers(string $id, EventFacade $eventFacade): JsonResponse
    {
        try {
            $users = $eventFacade->getEventEnrollmentsAndUsers((int) $id);
            return response()->json($users);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => trans('An error occurred.')]);
        }
    }

    public function exportEventUsers(int $id, EventFacade $eventFacade): BinaryFileResponse
    {
        /** @todo rewrite into ExportFacade and Excel */
        $data = $eventFacade->getEventEnrollmentsAndUsers($id);

        $filename = public_path('seznam_ucastniku.csv');

        $csvHandle = fopen($filename, 'w');
        $data->each(function ($row) use ($csvHandle)
        {
            $row['c_fields'] = json_encode($row['c_fields']);
            fputcsv($csvHandle, $row);
        });

        fclose($csvHandle);

        return response()->download($filename, 'seznam_ucastniku.csv', ['Content-Type' => 'text/csv']);
    }

    public function exportEventUsersEmails(int $id, EventFacade $eventFacade): BinaryFileResponse
    {
        /** @todo rewrite into ExportFacade and Excel */
        $data = $eventFacade->getEventUsersEmail($id);

        $filename = public_path('seznam_ucastniku_email.csv');

        $csvHandle = fopen($filename, 'w');
        $data->each(function ($row) use ($csvHandle)
        {
            fputcsv($csvHandle, $row);
        });

        fclose($csvHandle);

        return response()->download($filename, 'seznam_ucastniku_email.csv', ['Content-Type' => 'text/csv']);
    }

}
