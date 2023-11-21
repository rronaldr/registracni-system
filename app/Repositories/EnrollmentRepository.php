<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\EnrollmentStates;
use App\Models\Enrollment;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getByIdWithRelations(int $id): Enrollment
    {
        /** @var Enrollment $enrollment */
        $enrollment = Enrollment::query()
            ->with(['date', 'user', 'date.event'])
            ->where('id', $id)
            ->first();

        return $enrollment;
    }

    public function getEnrollmentsByUser(int $id): LengthAwarePaginator
    {
        return Enrollment::query()
            ->has('date.event')
            ->with(['date:id,date_start,date_end,event_id,withdraw_end', 'date.event:id,name'])
            ->where('user_id', $id)
            ->orderBy('created_at')
            ->paginate(5);
    }

    public function getFirstSubstituteEnrolled(int $dateId): ?Enrollment
    {
        /** @var Enrollment $enrollment */
        $enrollment =  Enrollment::query()
            ->with('user')
            ->where('date_id', $dateId)
            ->where('state', EnrollmentStates::SUBSTITUTE)
            ->orderBy('created_at')
            ->first();

        return $enrollment;
    }

    public function getSubstituteUserIds(int $dateId): array
    {
        return Enrollment::query()
            ->where('date_id', $dateId)
            ->where('state', EnrollmentStates::SUBSTITUTE)
            ->pluck('user_id')
            ->all();
    }

    public function getSubstituteCount(int $dateId): int
    {
        return Enrollment::query()
            ->where('date_id', $dateId)
            ->where('state', EnrollmentStates::SUBSTITUTE)
            ->count();
    }

    public function getEnrollmentByDateAndEmail(int $dateId, string $email): Enrollment
    {
        /** @var Enrollment $enrollment */
        $enrollment = Enrollment::query()
            ->where('date_id', $dateId)
            ->whereHas('user', function($q) use ($email) {
                $q->where('email', $email);
            })
            ->first();

        return $enrollment;
    }
}
