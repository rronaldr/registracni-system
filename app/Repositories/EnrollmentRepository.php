<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Enrollment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EnrollmentRepository
{

    public function getById(int $id): Enrollment
    {
        /** @var Enrollment $enrollment */
        $enrollment = Enrollment::query()
            ->where('id', $id)
            ->first();

        return $enrollment;
    }

    public function checkExistsEnrollmentByDateAndUser(int $dateId, int $userId): bool
    {
        $enrollment = Enrollment::query()
            ->where('date_id', $dateId)
            ->where('user_id', $userId)
            ->first();

        return !($enrollment === null);
    }

    public function getEnrollmentsByUser(int $id): LengthAwarePaginator
    {
        return Enrollment::query()
            ->with(['date:id,date_start,date_end,event_id', 'date.event:id,name'])
            ->where('user_id', $id)
            ->orderBy('created_at')
            ->paginate(5);
    }
}
