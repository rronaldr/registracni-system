<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Date;
use Illuminate\Support\Collection;

class DateRepository
{
    public function getEventWithStartAndEndDates(int $eventId): Collection
    {
        return Date::query()
            ->where('event_id', $eventId)
            ->orderBy('date_start')
            ->get(['date_start', 'date_end']);
    }
}
