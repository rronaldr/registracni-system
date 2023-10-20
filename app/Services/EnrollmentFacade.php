<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\EnrollmentStates;
use App\Models\Enrollment;
use App\Repositories\EnrollmentRepository;
use App\Services\Admin\DateFacade;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class EnrollmentFacade
{
    private EnrollmentRepository $enrollmentRepository;
    private UserFacade $userFacade;
    private EventFacade $eventFacade;
    private EmailFacade $emailFacade;
    private DateFacade $dateFacade;

    public function __construct(
        EnrollmentRepository $enrollmentRepository,
        UserFacade $userFacade,
        EventFacade $eventFacade,
        DateFacade $dateFacade,
        EmailFacade $emailFacade
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->userFacade = $userFacade;
        $this->eventFacade = $eventFacade;
        $this->dateFacade = $dateFacade;
        $this->emailFacade = $emailFacade;
    }

    public function createEnrollment(int $dateId, Request $request): void
    {
        $date = $this->dateFacade->getDateById($dateId);
        $user = $this->userFacade->getCurrentUser();
        $enrollmentData = collect($request->get('data'))->values()->toArray();

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'date_id' => $date->id,
            'state' => $date->getSignedCount() >= $date->capacity ? EnrollmentStates::SUBSTITUTE : EnrollmentStates::SIGNED,
            'c_fields' => $enrollmentData
        ]);

        $this->emailFacade->sendUserEnrolledEmail($enrollment->id);
    }

    public function getValidationRulesForTags(array $fields): ?array
    {
        return collect($fields)->mapWithKeys(function ($field): ?array {
            $rules = collect();
            if ($field['required']) {
                $rules->push('required');
            }

            switch ($field['type']) {
                case in_array($field['type'], ['text', 'url']):
                    $rules->push('string');
                    break;
                case in_array($field['type'], ['number', 'tel']):
                    $rules->push('numeric');
                    break;
                case 'email':
                    $rules->push('email');
                    break;
            }

            return [sprintf('%s.value', $field['value']) => $rules->implode('|')];
        })->filter(static fn($rule) => !empty($rule))->toArray();
    }

    public function checkExistingEnrollment(int $dateId, int $userId): bool
    {
        return $this->enrollmentRepository->checkExistsEnrollmentByDateAndUser($dateId, $userId);
    }

    public function getEnrollmentsForUser(int $id): LengthAwarePaginator
    {
        return $this->enrollmentRepository->getEnrollmentsByUser($id);
    }

}
