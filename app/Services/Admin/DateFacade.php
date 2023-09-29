<?php

declare(strict_types = 1);

namespace App\Services\Admin;

use App\Helpers\DateFormatter;
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

    public function createDate(int $eventId, array $data): void
    {
        $attributes = array_merge(['event_id' => $eventId], $this->getDataAttributesMapping($data));

        Date::create($attributes);
    }

    public function updateDate(int $dateId, array $data): void
    {
        $date = $this->dateRepository->getDateById($dateId);

        if ($date === null) {
            return;
        }

        $date->update($this->getDataAttributesMapping($data));
    }

    public function createDatesFromEvent(array $dates, int $eventId): void
    {
        collect($dates)
            ->each(function (array $date) use ($eventId){
                $this->createDate($eventId, $date);
            });
    }

    public function getDateValidationRules(): array
    {
        return [
            'date.location' => 'required|string',
            'date.capacity' => 'required_if:dates.*.unlimited_capacity,==,false|sometimes:numeric',
            'date.date_from' => 'required|date',
            'date.time_from' => 'required|date_format:H:i',
            'date.date_to' => 'required|date',
            'date.time_to' => 'required|date_format:H:i',
            'date.date_to' => 'required|date',
            'date.time_to' => 'required|date_format:H:i',
        ];
    }

    private function getDataAttributesMapping(array $data): array
    {
        return [
            'name' => $data['name'],
            'location' => $data['location'],
            'capacity' => !$data['unlimited_capacity'] ? $data['capacity'] : -1,
            'substitute' => $data['substitute'],
            'date_start' => DateFormatter::getDatetimeFromDateAndTime($data['date_from'], $data['time_from']),
            'date_end' => DateFormatter::getDatetimeFromDateAndTime($data['date_to'], $data['time_to']),
            'enrollment_start' => DateFormatter::getDatetimeFromDateAndTime($data['enrollment_from'], $data['enrollment_from_time']),
            'enrollment_end' => DateFormatter::getDatetimeFromDateAndTime($data['enrollment_to'], $data['enrollment_to_time']),
            'withdraw_end' => DateFormatter::getDatetimeFromDateAndTime($data['withdraw_date'], $data['withdraw_time']),
        ];
    }
}