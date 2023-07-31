<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Date;
use App\Repositories\DateRepository;
use Illuminate\Support\Collection;


class DateFacade
{

    private DateRepository $dateRepository;

    public function __construct(DateRepository $dateRepository){
        $this->dateRepository = $dateRepository;
    }
    public function getEventWithStartAndEndDates(int $eventId): Collection
    {
        return $this->dateRepository->getEventWithStartAndEndDates($eventId);
    }
}
