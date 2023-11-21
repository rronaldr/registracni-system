<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use App\Services\Admin\BlacklistFacade;
use App\Services\Admin\DateFacade;
use Illuminate\Pagination\LengthAwarePaginator;

class EventFacade
{
    private EventRepository $eventRepository;
    private DateFacade $dateFacade;
    private BlacklistFacade $blacklistFacade;

    public function __construct(
        EventRepository $eventRepository,
        DateFacade $dateFacade,
        BlacklistFacade $blacklistFacade
    ) {
        $this->eventRepository = $eventRepository;
        $this->dateFacade = $dateFacade;
        $this->blacklistFacade = $blacklistFacade;
    }

    public function getEventByIdForDetailPage(int $id): Event
    {
        return $this->eventRepository->getEventByIdForDetailPage($id);
    }

    public function getPublishedEventsWithActiveDates(): LengthAwarePaginator
    {
        return $this->eventRepository->getPublishedEventsWithActiveDates();
    }

    public function getEventCustomFields(int $dateId): Event
    {
        return $this->eventRepository->getEventCustomFields($dateId);
    }

    public function getEventById(int $id): Event
    {
        return $this->eventRepository->getEventById($id);
    }
}
