<?php

namespace App\Services\Admin;

use App\Enums\Event\EventStatusEnum;
use App\Models\Blacklist;
use App\Models\Event;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Throwable;

class EventFacade
{
    private EventRepository $eventRepository;
    private DateFacade  $dateFacade;
    private BlacklistFacade $blacklistFacade;
    private TagFacade $tagFacade;
    public function __construct(
        EventRepository $eventRepository,
        DateFacade $dateFacade,
        BlacklistFacade $blacklistFacade,
        TagFacade $tagFacade
    ){
        $this->eventRepository = $eventRepository;
        $this->dateFacade = $dateFacade;
        $this->blacklistFacade = $blacklistFacade;
        $this->tagFacade = $tagFacade;
    }

    public function createEvent(Request $request): void
    {
        $data = $request->all();
        $eventData = $data['event'];
        $dates = !empty($data['dates']) ? $data['dates'] : null;
        $tags = !empty($data['tags']) ? $data['tags'] : null;
        $blacklist = $eventData['event_blacklist']
            ? $this->blacklistFacade->createBlacklist()
            : null;

        if (isset($blacklist)) {
            $blacklistUsers = ['users' => $eventData['blacklist_users']];
            $this->blacklistFacade->addUsersToBlacklist($blacklist->id, $blacklistUsers);
        }

        $event = $this->createEventFromRequest($eventData, $tags, $blacklist);

        if (isset($dates)) {
            $this->dateFacade->createDatesFromEvent($dates, $event->id);
        }

        $this->setEventDateCache($event);
    }

    public function getEventsForOverviewPaginated(): LengthAwarePaginator
    {
        return $this->eventRepository->getEventsForOverviewPaginated();
    }

    public function deleteEvent(int $id): void
    {
        /** @var Event $event */
        $event = Event::query()
            ->where('id', $id)
            ->with(['dates', 'blacklist'])
            ->first();

        if (!isset($event)) {
            return;
        }

        $event->dates()->delete();
        $event->blacklist()->delete();
        $event->delete();
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
//                'c_fields' => $this->tagFacade->getCustomFieldsValueWithLabel($customFieldsLabels, $enrollment),
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

    public function getEventById(int $id): Event
    {
        return $this->eventRepository->getEventById($id);
    }

    public function getValidationRules(): array
    {
        return [
            'event.blacklist_id' => 'nullable|numeric',
            'event.name' => 'required|string',
            'event.type' => 'required|numeric',
            'event.blacklist_users' => 'required_if:event.event_blacklist,==,true|sometimes:string',
            'event.user_group' => 'required|numeric',
            'contact.*' => 'required',
            'dates' => 'required|array',
            'dates.*.location' => 'required|string',
            'dates.*.capacity' => 'required_if:dates.*.unlimited_capacity,==,false|sometimes:numeric',
            'dates.*.date_from' => 'required|date',
            'dates.*.time_from' => 'required|date_format:H:i',
            'dates.*.date_to' => 'required|date',
            'dates.*.time_to' => 'required|date_format:H:i',
            'tags.*' => 'sometimes|required',
            'tags.*.label' => 'required|string',
            'tags.*.value' => 'required|string',
            'tags.*.options' => 'required_if:tags.*.type,radio,checkbox,select'
        ];
    }

    private function setEventDateCache(Event $event): void
    {
        $dateCache = $this->dateFacade->getFirstAndLastDateOfEvent($event->id);
        $event->date_start_cache = Carbon::parse($dateCache->get('date_start'));
        $event->date_end_cache = Carbon::parse($dateCache->get('date_end'));
        $event->save();
    }

    private function createEventFromRequest(array $event, ?array $customFields, ?Blacklist $blacklist): Event
    {
        try {
            return Event::create([
                'blacklist_id' => $blacklist->id ?? null,
                'name' => $event['name'],
                'subtitle' => $event['subtitle'],
                'calendar_id' => $event['calendar_id'],
                'contact_person' => $event['contact']['person'],
                'contact_email' => $event['contact']['email'],
                'type' => $event['type'],
                'global_blacklist' => $event['global_blacklist'],
                'event_blacklist' => $event['event_blacklist'],
                'template_id' => $event['template']['id'],
                'template_content' => $event['template']['content'],
                'user_group' => (int) $event['user_group'],
                'c_fields' => $customFields !== null ? json_encode($customFields) : null,
                'user_id' => auth()->user()->id,
                'status' => EventStatusEnum::DRAFT,
            ]);
        } catch (Throwable $e) {
            dd($e);
        }
    }
}
