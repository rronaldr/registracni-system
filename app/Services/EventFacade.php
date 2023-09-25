<?php

declare(strict_types = 1);

namespace App\Services;

use App\Enums\Event\EventStatusEnum;
use App\Models\Blacklist;
use App\Models\Enrollment;
use App\Models\Event;
use App\Repositories\EventRepository;
use App\Services\Admin\BlacklistFacade;
use App\Services\Admin\DateFacade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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

    public function getEventByIdForDetailPage(int $id): Event
    {
        return $this->eventRepository->getEventByIdForDetailPage($id);
    }

    public function getEventsWithDatesInMonth(Carbon $month): Collection
    {
        return $this->eventRepository->getEventsWithDatesInMonth($month);
    }

    public function getEventCustomFields(int $dateId): Event
    {
        return $this->eventRepository->getEventCustomFields($dateId);
    }
}
