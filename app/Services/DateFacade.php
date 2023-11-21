<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Date;
use App\Repositories\DateRepository;
use App\Repositories\EnrollmentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class DateFacade
{

    private DateRepository $dateRepository;

    public function __construct(DateRepository $dateRepository, EnrollmentRepository $enrollmentRepository)
    {
        $this->dateRepository = $dateRepository;
    }

    public function getDateById(int $id): Date
    {
        return $this->dateRepository->getDateById($id);
    }

    public function getActiveEventDates(int $eventId): ?LengthAwarePaginator
    {
        return $this->dateRepository->getActiveEventDates($eventId);
    }
}
