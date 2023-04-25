<?php

declare(strict_types = 1);

namespace App\Services;

use App\Repositories\DateRepository;
use Illuminate\Support\Collection;


class DateFacade
{

    private DateRepository $dateRepository;

    public function __construct(DateRepository $dateRepository){
        $this->dateRepository = $dateRepository;
    }
    public function getEventDates(int $eventId): Collection
    {
        return $this->dateRepository->getEventDates($eventId);
    }
}
