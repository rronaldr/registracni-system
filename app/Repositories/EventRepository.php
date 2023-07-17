<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepository
{

    public function getEventsForOverviewPaginated(): LengthAwarePaginator
    {
        return Event::query()
            ->withCount(['dates', 'enrollments'])
            ->paginate(10);
    }

    /** @return \App\Models\Event */
    public function getEventEnrollmentsAndUsers(int $eventId): ?Event
    {
        return Event::query()
            ->where('id', $eventId)
            ->with('enrollments.user')
            ->firstOrFail();
    }

    public function getEventById(int $eventId): Model
    {
        return Event::query()
            ->where('id', $eventId)
            ->with('dates', function ($q) {
                $q->orderBy('date_start');
            })
            ->with('enrollments.user')
            ->firstOrFail();
    }

}
