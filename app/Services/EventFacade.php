<?php

declare(strict_types = 1);

namespace App\Services;

use App\Enums\Event\EventStatusEnum;
use App\Models\Blacklist;
use App\Models\Date;
use App\Models\Enrollment;
use App\Models\Event;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventFacade
{
    private EventRepository $eventRepository;
    private DateFacade  $dateFacade;
    private BlacklistFacade $blacklistFacade;
    public function __construct(
        EventRepository $eventRepository,
        DateFacade $dateFacade,
        BlacklistFacade $blacklistFacade
    ){
        $this->eventRepository = $eventRepository;
        $this->dateFacade = $dateFacade;
        $this->blacklistFacade = $blacklistFacade;
    }

    public function createEvent(Request $request): void
    {
        $data = $request->all();
        $eventData = $data['event'];
        $dates = $data['dates'] ?? null;
        $tags = $data['tags'] ?? null;

        $blacklist = $eventData['global_blacklist']
            ? $this->blacklistFacade->getGlobalBlacklist()
            : $this->blacklistFacade->createBlacklist();

        $blacklistUsers = ['users' => $eventData['blacklist_users']];
        $this->blacklistFacade->addUsersToBlacklist($blacklist->id, $blacklistUsers);

        $event = $this->createEventFromRequest($eventData, $blacklist);

        collect($dates)
            ->each(function (array $date) use ($event){
                $this->dateFacade->createDate($event->id, $date);
            });

        $this->setEventDateCache($event);
        // @todo save event tags
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
//                'c_fields' => $this->getCustomFieldsValueWithLabel($customFieldsLabels, $enrollment),
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
            'dates.*.capacity' => 'required|numeric',
            'dates.*.date_from' => 'required|date',
            'dates.*.time_from' => 'required|date_format:H:i',
            'dates.*.date_to' => 'required|date',
            'dates.*.time_to' => 'required|date_format:H:i',
            'tags.*' => 'sometimes|required',
            'tags.*.label' => 'required|string',
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

    private function getCustomFieldsValueWithLabel(array $labels, Enrollment $enrollment): Collection
    {
        /** @todo refactor custom field label is taken from event */
        $data = collect(json_decode($enrollment->c_fields, true));
        return $data->mapWithKeys(function ($value, $key) use ($labels): array
        {
            return [$labels[$key]['label'] => $value];
        });
    }

    private function createEventFromRequest(array $event, Blacklist $blacklist): Event
    {
        return Event::create([
            'blacklist_id' => $blacklist->id,
            'name' => $event['name'],
            'subtitle' => $event['subtitle'],
            'external_login' => $event['external_login'],
            'template_id' => $event['template']['id'],
            'user_id' => auth()->user()->id,
            'calendar_id' => $event['calendar_id'],
            'contact_person' => $event['contact']['person'],
            'contact_email' => $event['contact']['email'],
            'type' => $event['type'],
            'status' => EventStatusEnum::DRAFT,
            'template_content' => $event['template']['content'],
            'user_group' => (int) $event['user_group'],
        ]);
    }
}
