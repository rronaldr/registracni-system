<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Enums\Event\EventStatusEnum;
use App\Exceptions\InvalidXnameUser;
use App\Models\Event;
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

    public function createEvent(array $data): void
    {
        $user = $this->userRepository->getByXname($data['event']['user']['xname']);

        if ($user === null) {
            throw new InvalidXnameUser;
        }

        $eventData = $data['event'];
        $dates = !empty($data['dates']) ? $data['dates'] : null;

        $event = $this->createEventFromData($eventData, $user->id);

        if (isset($dates)) {
            $this->dateFacade->createDatesFromEvent($dates, $event->id);
        }

        $this->setEventDateCache($event->id);
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
            'event.user.xname' => 'required|string',
            'event.user.name' => 'required|string',
            'event.user.email' => 'required|email',
            'event.calendar_id' => 'sometimes|numeric',
            'event.global_blacklist' => 'required|boolean',
            'dates' => 'required|array',
            'dates.*.location' => 'sometimes|string|required_if:dates.*.online,==,false',
            'dates.*.unlimited_capacity' => 'required|boolean',
            'dates.*.capacity' => 'required_if:dates.*.unlimited_capacity,==,false|sometimes|numeric',
            'dates.*.date_start' => 'required|date_format:Y-m-d H:i',
            'dates.*.date_end' => 'required|date_format:Y-m-d H:i',
            'dates.*.enrollment_start' => 'required|date_format:Y-m-d H:i',
            'dates.*.enrollment_end' => 'required|date_format:Y-m-d H:i',
            'dates.*.withdraw_end' => 'required|date_format:Y-m-d H:i',
        ];
    }

    private function createEventFromData(array $event, int $userId): Event
    {
        return Event::create([
            'blacklist_id' => null,
            'subtitle' => $event['subtitle'],
            'calendar_id' => is_int($event['calendar_id']) ? $event['calendar_id'] : null,
            'contact_person' => $event['user']['name'],
            'contact_email' => $event['user']['email'],
            'type' => $event['type'],
            'global_blacklist' => $event['global_blacklist'],
            'user_group' => (int) $event['user_group'],
            'user_id' => $userId,
            'name' => $event['name'],
            'c_fields' => null,
            'event_blacklist' => false,
            'status' => EventStatusEnum::DRAFT,
            'template_id' => 0
        ]);
    }
}