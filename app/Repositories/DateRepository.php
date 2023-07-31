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

    public function getDateById(int $id): Date
    {
        /** @var \App\Models\Date $date */
        $date = Date::query()
            ->where('id', $id)
            ->with('event.template')
            ->first();

        return $date;
    }
}
