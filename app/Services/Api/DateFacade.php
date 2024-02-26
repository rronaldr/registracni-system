<?php

declare(strict_types = 1);

namespace App\Services\Api;

use App\Helpers\DateFormatter;
use App\Models\Date;
use App\Repositories\DateRepository;
use App\Repositories\EnrollmentRepository;
use Illuminate\Support\Collection;

class DateFacade
{
    private DateRepository $dateRepository;

    public function __construct(DateRepository $dateRepository, EnrollmentRepository $enrollmentRepository)
    {
        $this->dateRepository = $dateRepository;
    }

    public function createDatesFromEvent(array $dates, int $eventId): void
    {
        collect($dates)
            ->each(function (array $date) use ($eventId) {
                $this->createDate($eventId, $date);
            });
    }

    public function createDate(int $eventId, array $data): Date
    {
        $attributes = array_merge(['event_id' => $eventId], $this->getDataAttributesMapping($data));

        return Date::create($attributes);
    }

    public function getFirstAndLastDateOfEvent(int $eventId): Collection
    {
        return $this->dateRepository->findFirstAndLastDateOfEvent($eventId);
    }

    private function getDataAttributesMapping(array $data): array
    {
        return [
            'name' => null,
            'location' => $data['location'],
            'capacity' => !isset($data['unlimited_capacity']) || !$data['unlimited_capacity'] ? $data['capacity'] : -1,
            'substitute' => $data['substitute'] ?? false,
            'date_start' => $data['date_start'],
            'date_end' => $data['date_end'],
            'enrollment_start' => $data['enrollment_start'],
            'enrollment_end' => $data['enrollment_end'],
            'withdraw_end' => $data['withdraw_end'],
        ];
    }
}