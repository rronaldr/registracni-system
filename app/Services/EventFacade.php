<?php

declare(strict_types = 1);

namespace App\Services;

use App\Enums\Event\EventStatusEnum;
use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EventFacade
{
    private EventRepository $eventRepository;
    private DateFacade  $dateFacade;
    public function __construct(
        EventRepository $eventRepository,
        DateFacade $dateFacade
    ){
        $this->eventRepository = $eventRepository;
        $this->dateFacade = $dateFacade;
    }

    public function createEvent(Request $request): void
    {
        $event = Event::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'type' => $request->get('type'),
            'status' => EventStatusEnum::DRAFT,
            'blacklist_id' => null,
            'hidden' => 0,
        ]);

    }

    public function getEventsForOverviewPaginated(): LengthAwarePaginator
    {
        return $this->eventRepository->getEventsForOverviewPaginated();
    }

    public function deleteEvent(Event $event): void
    {
        $event->deleteOrFail();
    }

    public function duplicateEvent(Event $event): Event
    {
        /** @var \App\Models\Event $duplicate */
        $duplicate = $event->replicate();
        $duplicate->name = $duplicate->name.' (copy)';
        $duplicate->push();

        $event->load('dates');

        foreach ($event->getRelation('dates') as $date) {
            unset($date->id);
            unset($date->event_id);
            $duplicate->dates()->create($date->toArray());
        }

        return $duplicate;
    }

    public function getEventEnrollmentsAndUsers(int $id): ?Collection
    {
        /** @var App\Models\Event $event */
        $event = $this->eventRepository->getEventEnrollmentsAndUsers($id);

        $eventUsersList = collect();
        foreach ($event->enrollments as $enrollment) {
            $eventUsersList->push([
                'id'=> $enrollment->user->id,
                'name' => $enrollment->user->first_name,
                'email' => $enrollment->user->email,
                'c_fields' => json_decode($enrollment->c_fields),
                'enrolled' => $enrollment->created_at,
            ]);
        }

        return $eventUsersList->unique('name');
    }

    public function getEventUsersEmail(int $eventId): Collection
    {
        /** @var App\Models\Event $event */
        $event = $this->eventRepository->getEventEnrollmentsAndUsers($eventId);

        $eventUsersList = collect();
        foreach ($event->enrollments as $enrollment) {
            $eventUsersList->push([
                'email' => $enrollment->user->email,
            ]);
        }

        return $eventUsersList->unique('email');
    }

    public function getEventDates(int $eventId): Collection
    {
        return $this->dateFacade->getEventDates($eventId);
    }

    public function getEventById(int $eventId): Model
    {
        return $this->eventRepository->getEventById($eventId);
    }
}
