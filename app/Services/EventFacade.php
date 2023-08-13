<?php

declare(strict_types = 1);

namespace App\Services;

use App\Enums\Event\EventStatusEnum;
use App\Models\Enrollment;
use App\Models\Event;
use App\Repositories\EventRepository;
use Carbon\Carbon;
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
        Event::create([
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
        /** @var \App\Models\Event $event */
        $event = $this->eventRepository->getEventWithEnrollmentsAndUsers($id);
        $customFieldsLabels = json_decode($event->c_fields, true);

        $eventUsersList = collect();
        foreach ($event->enrollments as $enrollment) {
            $eventUsersList->push([
                'id'=> $enrollment->user->id,
                'xname' => $enrollment->user->xname,
                'email' => $enrollment->user->email,
                'c_fields' => $this->getCustomFieldsValueWithLabel($customFieldsLabels, $enrollment),
                'enrolled' => $enrollment->created_at,
            ]);
        }

        return $eventUsersList->unique('xname');
    }

    public function getEventUsersEmail(int $eventId): Collection
    {
        /** @var \App\Models\Event $event */
        $event = $this->eventRepository->getEventWithEnrollmentsAndUsers($eventId);

        $eventUsersList = collect();
        foreach ($event->enrollments as $enrollment) {
            $eventUsersList->push([
                'email' => $enrollment->user->email,
            ]);
        }

        return $eventUsersList->unique('email');
    }

    public function getEventWithStartAndEndDates(int $eventId): Collection
    {
        return $this->dateFacade->getEventWithStartAndEndDates($eventId);
    }

    public function getEventsWithDatesInMonth(Carbon $month): Collection
    {
        return $this->eventRepository->getEventsWithDatesInMonth($month);
    }

    public function getEventById(int $id): Event
    {
        return $this->eventRepository->getEventById($id);
    }

    public function getEventCustomFields(int $dateId): Event
    {
        return $this->eventRepository->getEventCustomFields($dateId);
    }

    public function getEventByIdForDetailPage(int $id): Event
    {
        return $this->eventRepository->getEventByIdForDetailPage($id);
    }

    private function getCustomFieldsValueWithLabel(array $labels, Enrollment $enrollment): Collection
    {
        /** @todo refactor custom field label is taken from event */
        $data = collect(json_decode($enrollment->c_fields, true));
        return $data->mapWithKeys(function ($value, $key) use ($labels): array
        {
            return [$labels[$key]['label'] => $value];
        });
    }
}
