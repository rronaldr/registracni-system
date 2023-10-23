<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\EnrollmentStates;
use App\Models\Enrollment;
use App\Repositories\EnrollmentRepository;
use App\Services\Admin\DateFacade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class EnrollmentFacade
{
    private EnrollmentRepository $enrollmentRepository;
    private UserFacade $userFacade;
    private DateFacade $dateFacade;
    private EmailFacade $emailFacade;

    public function __construct(
        EnrollmentRepository $enrollmentRepository,
        UserFacade $userFacade,
        DateFacade $dateFacade,
        EmailFacade $emailFacade
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->userFacade = $userFacade;
        $this->dateFacade = $dateFacade;
        $this->emailFacade = $emailFacade;
    }

    public function getEnrollmentById(int $id): Enrollment
    {
        return $this->enrollmentRepository->getById($id);
    }

    public function createEnrollment(int $dateId, Request $request): Enrollment
    {
        $date = $this->dateFacade->getDateById($dateId);
        $user = $this->userFacade->getCurrentUser();
        $enrollmentData = collect($request->get('data'))->values()->toArray();
        $state = EnrollmentStates::SIGNED;

        if ($user->cannot('enroll', [Enrollment::class, $date]) && $user->can('substituteEnroll', [Enrollment::class, $date])
        ) {
            $state = EnrollmentStates::SUBSTITUTE;
        }

        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'date_id' => $date->id,
            'state' => $state,
            'c_fields' => $enrollmentData
        ]);

        return $enrollment;
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

    public function getEnrollmentsForUser(int $id): LengthAwarePaginator
    {
        return $this->enrollmentRepository->getEnrollmentsByUser($id);
    }

    public function enrollUserByEmail(int $id, string $email): bool
    {
        $date = $this->dateFacade->getDateById($id);

        if ($date->getSignedCount() < $date->capacity) {
            $enrollment = $this->enrollmentRepository->getEnrollmentByDateAndEmail($id, $email);
            $enrollment->state = EnrollmentStates::SIGNED;
            $enrollment->save();

            return true;
        }

        return false;
    }

    public function signOffUser(Enrollment $enrollment): void
    {
        $enrollment->state = EnrollmentStates::SIGNED_OFF;
        $enrollment->save();

        $this->enrollSubstitutes($enrollment);
    }

    private function enrollSubstitutes(Enrollment $enrollment): void
    {
        $date = $enrollment->date;
        $substitutesCount = $this->enrollmentRepository->getSubstituteCount($date->id);
        if (!$date->substitute || $substitutesCount === 0) {
            return;
        }

        $dayBeforeWithdrawEnd = Carbon::parse($date->withdraw_end)->subDay();

        if ($dayBeforeWithdrawEnd < Carbon::now()) {
            $userIds = $this->enrollmentRepository->getSubstituteUserIds($date->id);
            $userEmails = $this->userFacade->getUsersEmailsAndLocaleByIds($userIds);
            $this->emailFacade->sendFreeSpotNotificationToSubstitutes($date, $userEmails);

            return;
        }

        $firstSubstituteEnrollment = $this->enrollmentRepository->getFirstSubstituteEnrolled($date->id);
        $firstSubstituteEnrollment->state = EnrollmentStates::SIGNED;
        $firstSubstituteEnrollment->save();

        $this->emailFacade->sendSubstituteEnrolled($date, $firstSubstituteEnrollment->user);
    }

}
