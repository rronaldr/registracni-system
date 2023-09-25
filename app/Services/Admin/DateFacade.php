<?php

declare(strict_types = 1);

namespace App\Services\Admin;

use App\Models\Date;
use App\Repositories\DateRepository;
use Carbon\Carbon;
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

    public function getDateById(int $id): Date
    {
        return $this->dateRepository->getDateById($id);
    }

    public function getFirstAndLastDateOfEvent(int $eventId): Collection
    {
        return $this->dateRepository->findFirstAndLastDateOfEvent($eventId);
    }

    public function getEventDates(int $id): Collection
    {
        return $this->dateRepository->getEventDates($id);
    }

    public function createDate(int $eventId, array $date): Date
    {
        return Date::create([
            'event_id' => $eventId,
            'name' => $date['name'],
            'location' => $date['location'],
            'capacity' => !$date['unlimited_capacity'] ? $date['capacity'] : -1,
            'substitute' => $date['substitute'],
            'date_start' => Carbon::parse(sprintf('%s %s',$date['date_from'], $date['time_from'])) ?? null,
            'date_end' => Carbon::parse(sprintf('%s %s',$date['date_to'], $date['time_to'])) ?? null,
            'enrollment_start' => Carbon::parse(sprintf('%s %s',$date['enrollment_from'], $date['enrollment_from_time'])) ?? null,
            'enrollment_end' => Carbon::parse(sprintf('%s %s',$date['enrollment_to'], $date['enrollment_to_time'])) ?? null,
            'withdraw_end' => Carbon::parse(sprintf('%s %s',$date['withdraw_date'], $date['withdraw_time'])) ?? null,
        ]);
    }

    public function createDatesFromEvent(array $dates, int $eventId): void
    {
        collect($dates)
            ->each(function (array $date) use ($eventId){
                $this->createDate($eventId, $date);
            });
    }
}
