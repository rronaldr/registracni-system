<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Mockery\ExpectationDirector;

class EventRepository
{

    public function getEventsForOverviewPaginated()
    {
        Event::paginate(10);
    }

    public function getEventEnrollmentsAndUsers(int $eventId): Model
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
