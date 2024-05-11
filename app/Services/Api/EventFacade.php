<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Enums\Event\EventStatusEnum;
use App\Exceptions\InvalidXnameUser;
use App\Models\Event;
use App\Models\User;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class EventFacade
{

    private EventRepository $eventRepository;
    private UserRepository $userRepository;
    private DateFacade $dateFacade;

    public function __construct(
        EventRepository $eventRepository,
        UserRepository $userRepository,
        DateFacade $dateFacade
    ) {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
        $this->dateFacade = $dateFacade;
    }

    public function createEvent(array $data): int
    {
        $user = $this->userRepository->getUserById($data['event']['user']['id']);

        if ($user === null) {
            throw new InvalidXnameUser;
        }

        $eventData = $data['event'];
        $dates = !empty($data['event']['dates']) ? $data['event']['dates'] : null;

        $event = $this->createEventFromData($eventData, $user);

        if (isset($dates)) {
            $this->dateFacade->createDatesFromEvent($dates, $event->id);
        }

        $this->setEventDateCache($event->id);

        return $event->id;
    }

    public function setEventDateCache(int $id): void
    {
        $event = $this->eventRepository->getEventById($id);

        if ($event->dates()->count() === 0) {
            return;
        }

        $dateCache = $this->dateFacade->getFirstAndLastDateOfEvent($event->id);
        $event->date_start_cache = Carbon::parse($dateCache->get('date_start'));
        $event->date_end_cache = Carbon::parse($dateCache->get('date_end'));
        $event->save();
    }

    public function getEventById(int $id): ?Event
    {
        return $this->eventRepository->getEventById($id);
    }
    public function getEventByCalendarId(int $id): ?Event
    {
        return $this->eventRepository->getEventByCalendarId($id);
    }

    public function getEventValidationRules(): array
    {
        return [
            'event.name' => 'required|string',
            'event.subtitle' => 'string',
            'event.type' => 'required|numeric',
            'event.user_group' => 'required|numeric',
            'event.user.id' => 'required|numeric',
            'event.calendar_id' => 'sometimes|numeric',
            'event.global_blacklist' => 'required|boolean',
            'event.dates' => 'required|array',
            'event.dates.*.location' => 'sometimes|string|required_if:dates.*.online,==,false',
            'event.dates.*.unlimited_capacity' => 'required|boolean',
            'event.dates.*.capacity' => 'required_if:dates.*.unlimited_capacity,==,false|sometimes|numeric',
            'event.dates.*.date_start' => 'required|date_format:Y-m-d H:i',
            'event.dates.*.date_end' => 'required|date_format:Y-m-d H:i',
            'event.dates.*.enrollment_start' => 'required|date_format:Y-m-d H:i',
            'event.dates.*.enrollment_end' => 'required|date_format:Y-m-d H:i',
            'event.dates.*.withdraw_end' => 'sometimes|date_format:Y-m-d H:i',
        ];
    }

    private function createEventFromData(array $event, User $user): Event
    {
        return Event::create([
            'blacklist_id' => null,
            'subtitle' => $event['subtitle'],
            'calendar_id' => is_int($event['calendar_id']) ? $event['calendar_id'] : null,
            'contact_person' => $user->getFullname(),
            'contact_email' => $user->email,
            'type' => $event['type'],
            'global_blacklist' => $event['global_blacklist'],
            'user_group' => (int) $event['user_group'],
            'user_id' => $user->id,
            'name' => $event['name'],
            'c_fields' => null,
            'event_blacklist' => false,
            'status' => EventStatusEnum::DRAFT,
            'template_id' => 0
        ]);
    }
}