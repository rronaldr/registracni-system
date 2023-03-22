<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\Event\EventFacade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::paginate(10);

        return view('admin.events', [
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        return view('admin.event-form');
    }
    public function store(Request $request, EventFacade $eventFacade): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|numeric',
        ]);

        try {
            $eventFacade->createEventFromRequest($request);
        } catch (\Exception $e) {
            dump($e);
        }

        Session::flash('message', 'Událost byla uložena');

        return redirect()->route('admin.events.index');
    }

    public function show(string $id): View
    {
        return view('admin.event-form');
    }

    public function edit(string $id): View
    {
        return view('admin.event-form');
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

        Session::flash('message', 'Událost smazaná');

        return redirect()->route('admin.events.index');
    }

    public function duplicate(Event $event, EventFacade $eventFacade): RedirectResponse
    {
        try {
            $eventFacade->duplicateEvent($event);
        } catch (\Exception $e){
            dump($e);
        }

        Session::flash('message', 'Událost zduplikovaná');

        return redirect()->route('admin.events.index');
    }

}
