<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Date;
use App\Repositories\DateRepository;
use App\Repositories\EnrollmentRepository;

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
}
