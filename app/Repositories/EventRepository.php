<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\EnrollmentStates;
use App\Enums\Event\EventStatusEnum;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepository
{

    public function getEventsPaginated(): LengthAwarePaginator
    {
        return Event::query()
            ->withCount(['dates'])
            ->orderBy('date_start_cache')
            ->paginate(10);
    }

    public function getEventsByAuthorPaginated(int $id, ?SupportCollection $collaborationIds): LengthAwarePaginator
    {
        $query = Event::query()
            ->withCount(['dates'])
            ->where('user_id', $id)
            ->orderBy('date_start_cache');

        if ($collaborationIds !== null) {
            $query->orWhereIn('id', $collaborationIds->toArray());
        }

        return $query->paginate(10);
    }

    public function getEventWithEnrollmentsAndUsers(int $eventId): ?Event
    {
        /** @var \App\Models\Event $event */
        $event = Event::query()
            ->where('id', $eventId)
            ->with('enrollments.user')
            ->firstOrFail();

        return $event;
    }

    public function getEventById(int $id): Event
    {
        /** @var \App\Models\Event $event */
        $event = Event::query()
            ->where('id', $id)
            ->firstOrFail();

        return $event;
    }

    public function getEventByIdForDetailPage(int $id)
    {
        /** @var \App\Models\Event $event */
        $event = Event::query()
            ->where('id', $id)
            ->with([
                'dates' => fn($q) => $q->withCount([
                    'enrollments' => fn($q) => $q->where('state', EnrollmentStates::SIGNED)
                ]),
                'author:id,first_name,last_name,email'
            ])
            ->firstOrFail();

        return $event;
    }

    public function getEventCustomFields(int $dateId): Event
    {
        /** @var \App\Models\Event $event */
        $event = Event::query()
            ->with(['dates' => fn($q) => $q->where('id', $dateId)])
            ->select('id', 'c_fields')
            ->first();

        return $event;
    }

    public function getPublishedEventsWithDatesInMonth(Carbon $month): Collection
    {
        /** @var \App\Models\Event $event * */
        $events = Event::query()
            ->with('dates', fn($q) => $q->whereBetween('date_start', [
                $month->startOfMonth()->toDateString(),
                $month->endOfMonth()->toDateString()
            ]))
            ->where('status', EventStatusEnum::PUBLISHED)
            ->where('date_end_cache', '>=', Carbon::now())
            ->get();

        return $events;
    }

    public function getEventForExportById(int $id): Event
    {
        /** @var \App\Models\Event $event */
        $event = Event::query()
            ->where('id', $id)
            ->with('dates:event_id,location,capacity,date_start,date_end,enrollment_start,enrollment_end,withdraw_end')
            ->select([
                'id', 'name', 'subtitle', 'calendar_id', 'contact_person', 'contact_email', 'template_content', 'type',
                'global_blacklist', 'event_blacklist', 'status', 'user_group'
            ])
            ->first();

        return $event;
    }

}
