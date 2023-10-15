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
    private DateFacade $dateFacade;
    private BlacklistFacade $blacklistFacade;
    private TagFacade $tagFacade;

    public function __construct(
        EventRepository $eventRepository,
        DateFacade $dateFacade,
        BlacklistFacade $blacklistFacade,
        TagFacade $tagFacade
    ) {
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

        $this->setEventDateCache($event->id);
    }

    public function updateEvent(int $eventId, array $data): void
    {
        $event = $this->getEventById($eventId);
        $event->update($this->getDataAttributesMapping($data['event']));
    }

    public function getEventsPaginated(): LengthAwarePaginator
    {
        return $this->eventRepository->getEventsPaginated();
    }

    public function getEventsByAuthor(int $id, ?Collection $collaborationsIds): LengthAwarePaginator
    {
        return $this->eventRepository->getEventsByAuthorPaginated($id, $collaborationsIds);
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

    public function duplicateEvent(int $id): Event
    {
        /** @var \App\Models\Event $duplicate */
        $duplicate = $this->getEventById($id)->withoutRelations();
        $duplicate->name = $duplicate->name.' (copy)';

        return $duplicate;
    }

    public function getEventEnrollmentsAndUsers(int $id): ?Collection
    {
        /** @var \App\Models\Event $event */
        $event = $this->eventRepository->getEventWithEnrollmentsAndUsers($id);

        $eventUsersList = collect();
        foreach ($event->enrollments as $enrollment) {
            $eventUsersList->push([
                'id' => $enrollment->user->id,
                'xname' => $enrollment->user->xname,
                'email' => $enrollment->user->email,
                'c_fields' => $this->tagFacade->getTagsWithLabelAndValue($enrollment),
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

    public function getEventById(int $id): Event
    {
        return $this->eventRepository->getEventById($id);
    }

    public function getEventCreateValidationRules(): array
    {
        return [
            'event.blacklist_id' => 'nullable|numeric',
            'event.name' => 'required|string',
            'event.type' => 'required|numeric',
            'event.blacklist_users' => 'required_if:event.event_blacklist,==,true|sometimes:string',
            'event.user_group' => 'required|numeric',
            'event.contact.person' => 'required|string',
            'event.contact.email' => 'required|email',
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

    public function getEventUpdateValidationRules(): array
    {
        return [
            'event.name' => 'required|string',
            'event.subtitle' => 'string|nullable',
            'event.blacklist_id' => 'nullable|numeric',
            'event.type' => 'required|numeric',
            'event.user_group' => 'required|numeric',
            'event.contact.person' => 'required|string',
            'event.contact.email' => 'required|email',
            'event.global_blacklist' => 'required|boolean',
            'event.event_blacklist' => 'required|boolean',
            'event.status' => 'required|numeric',
        ];
    }

    public function setEventDateCache(int $id): void
    {
        $event = $this->eventRepository->getEventById($id);
        $dateCache = $this->dateFacade->getFirstAndLastDateOfEvent($event->id);
        $event->date_start_cache = Carbon::parse($dateCache->get('date_start'));
        $event->date_end_cache = Carbon::parse($dateCache->get('date_end'));
        $event->save();
    }

    public function addEventCollaborator(int $id, int $collaboratorId, int $currentUserId): void
    {
        $event = $this->eventRepository->getEventById($id);

        if ($event->collaborators()->where('user_id', $collaboratorId)->get()->isNotEmpty()) {
            return;
        }

        $event->collaborators()->attach($collaboratorId,[
            'granted_by' => $currentUserId
        ]);
    }

    private function createEventFromRequest(array $event, ?array $customFields, ?Blacklist $blacklist): Event
    {
        return Event::create([
            'blacklist_id' => $blacklist->id ?? null,
            'name' => $event['name'],
            'subtitle' => $event['subtitle'],
            'calendar_id' => is_int($event['calendar_id']) ? $event['calendar_id'] : $this->parseCalendarEventId($event['calendar_id']),
            'contact_person' => $event['contact']['person'],
            'contact_email' => $event['contact']['email'],
            'type' => $event['type'],
            'global_blacklist' => $event['global_blacklist'],
            'event_blacklist' => $event['event_blacklist'],
            'template_id' => $event['template']['id'],
            'template_content' => $event['template']['content'],
            'user_group' => (int) $event['user_group'],
            'c_fields' => $customFields ?? null,
            'user_id' => auth()->user()->id,
            'status' => EventStatusEnum::DRAFT,
        ]);
    }

    private function getDataAttributesMapping(array $data): array
    {
        return [
            'name' => $data['name'],
            'subtitle' => $data['subtitle'],
            'calendar_id' => is_int($data['calendar_id']) ? $data['calendar_id'] : $this->parseCalendarEventId($data['calendar_id']),
            'contact_person' => $data['contact']['person'],
            'contact_email' => $data['contact']['email'],
            'type' => $data['type'],
            'global_blacklist' => (bool) $data['global_blacklist'],
            'event_blacklist' => (bool) $data['event_blacklist'],
            'template_id' => $data['template']['id'],
            'template_content' => $data['template']['content'],
            'user_group' => (int) $data['user_group'],
            'status' => $data['status'],
            'last_changed_by' => auth()->user()->id
        ];
    }

    private function parseCalendarEventId($calendar): ?int
    {
        $pattern = '/\bdate=([0-9]{4})\b/';

        if (preg_match($pattern, $calendar, $matches)) {
            $dateParam = $matches[1]; // The date parameter value will be in $matches[1]
            return $dateParam;
        } else {
            return null;
        }
    }
}
