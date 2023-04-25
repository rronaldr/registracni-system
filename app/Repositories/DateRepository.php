<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Date;
use Illuminate\Support\Collection;

class DateRepository
{

    public function getFirstAndLastDateOfEvent(int $eventId): Collection
    {
        return Date::query()
            ->where('event_id', $eventId)
            ->orderBy('date_start')
            ->pluck('date_start')
            ->last();
    }

    public function getEventDates(int $eventId): Collection
    {
        return Date::query()
            ->where('event_id', $eventId)
            ->orderBy('date_start')
            ->get(['date_start', 'date_end']);
    }
}
