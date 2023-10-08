<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Enrollment;

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
}
