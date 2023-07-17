<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Template;
use App\Models\User;
use App\Services\EventFacade;
use App\Services\TemplateFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

    public function create(TemplateFacade $templateFacade): View
    {
        $templates = $templates = Template::query()
            ->where('approved', 1)
            ->get();

        return view('admin.event-create', [
            'templates' => $templates,
        ]);
    }
    public function store(Request $request, EventFacade $eventFacade): RedirectResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'description' => 'nullable|string',
                'type' => 'required|numeric',
            ]);

            $eventFacade->createEvent($request);
        } catch (\Exception $e) {
            dump($e);
        }

        Session::flash('message', trans('event.saved'));

        return redirect()->route('admin.events');
    }

    public function show(string $id): View
    {
        return view('admin.event-detail');
    }

    public function edit(string $id, EventFacade $eventFacade, TemplateFacade $templateFacade): View
    {
        $event = $eventFacade->getEventById((int) $id);
        $templates = Template::query()
            ->where('approved', 1)
            ->get();

        return view('admin.event-edit', [
            'event' => $event,
            'templates' => $templates,
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

        Session::flash('message', trans('event.deleted'));

        return redirect()->route('admin.events');
    }

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

    public function getEventDates(string $eventId, EventFacade $eventFacade): JsonResponse
    {
        try {
            $dates = $eventFacade->getEventDates((int) $eventId);
            return response()->json($dates);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => trans('An error occurred.')]);
        }
    }

    public function getEventEnrollmentsUsers(string $eventId, EventFacade $eventFacade): JsonResponse
    {
        try {
            $users = $eventFacade->getEventEnrollmentsAndUsers((int) $eventId);
            return response()->json($users);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => trans('An error occurred.')]);
        }
    }

    public function exportEventUsers(string $eventId, EventFacade $eventFacade): BinaryFileResponse
    {
        /** @todo rewrite into ExportFacade */
        $data = $eventFacade->getEventEnrollmentsAndUsers($eventId);

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

    public function exportEventUsersEmails(string $eventId, EventFacade $eventFacade): BinaryFileResponse
    {
        /** @todo rewrite into ExportFacade */
        $data = $eventFacade->getEventUsersEmail($eventId);

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
