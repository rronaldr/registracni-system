<?php

declare(strict_types = 1);

namespace App\Services\Event;

use App\Enums\Event\EventStatusEnum;
use App\Models\Event;
use App\Repositories\Event\EventRepository;
use Illuminate\Http\Request;

class EventFacade
{

    private EventRepository $eventRepository;

    public function createEventFromRequest(Request $request): void
    {
        Event::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'type' => $request->get('type'),
            'status' => EventStatusEnum::DRAFT,
            'blacklist_id' => null,
        ]);
    }

    public function deleteEvent(Event $event): void
    {
        $event->deleteOrFail();
    }

    public function duplicateEvent(Event $event): void
    {
        $newEvent = $event->replicate();
        $newEvent->name = $newEvent->name.' (copy)';
        $newEvent->save();
    }
}
