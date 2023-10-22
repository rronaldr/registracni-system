<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Enums\EnrollmentStates;
use App\Helpers\DateFormatter;
use App\Models\Date;
use App\Models\Enrollment;
use App\Repositories\DateRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\UserRepository;
use App\Services\EmailFacade;
use Carbon\Carbon;
use Illuminate\Support\Collection;


class DateFacade
{

    private DateRepository $dateRepository;
    private EnrollmentRepository $enrollmentRepository;
    private EmailFacade $emailFacade;
    private UserRepository $userRepository;

    public function __construct(DateRepository $dateRepository, EnrollmentRepository $enrollmentRepository, EmailFacade $emailFacade, UserRepository $userRepository)
    {
        $this->dateRepository = $dateRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->emailFacade = $emailFacade;
        $this->userRepository = $userRepository;
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

    public function createDate(int $eventId, array $data): Date
    {
        $attributes = array_merge(['event_id' => $eventId], $this->getDataAttributesMapping($data));

        return Date::create($attributes);
    }

    public function updateDate(int $dateId, array $data): ?Date
    {
        $date = $this->dateRepository->getDateById($dateId);

        if ($date === null) {
            return null;
        }

        $date->update($this->getDataAttributesMapping($data));
        $date->refresh();

        return $date;
    }

    public function removeDate(int $id): void
    {
        $date = $this->dateRepository->getDateById($id);
        $date->enrollments()->delete();
        $date->delete();
    }

    public function getDateEnrollmentIds(int $id): Collection
    {
        $date = $this->dateRepository->getDateById($id);

        return $date->enrollments()->pluck('id');
    }

    public function createDatesFromEvent(array $dates, int $eventId): void
    {
        collect($dates)
            ->each(function (array $date) use ($eventId) {
                $this->createDate($eventId, $date);
            });
    }

    public function getDateEnrollments(int $id): Date
    {
        return $this->dateRepository->getDateEnrollments($id);
    }

    public function signOffUser(int $id): void
    {
        $enrollment = $this->enrollmentRepository->getById($id);
        $enrollment->state = EnrollmentStates::SIGNED_OFF;
        $enrollment->save();

        $this->enrollSubstitutes($enrollment);
    }

    public function getDatesWithEnrollmentEnding(Carbon $date): Collection
    {
        return $this->dateRepository->getDatesByEnrollmentFromDate($date);
    }

    public function getDateValidationRules(): array
    {
        return [
            'date.location' => 'required|string',
            'date.capacity' => 'required_if:date.unlimited_capacity,==,false|sometimes:numeric',
            'date.date_from' => 'required|date',
            'date.time_from' => 'required|date_format:H:i',
            'date.date_to' => 'required|date',
            'date.time_to' => 'required|date_format:H:i',
            'date.enrollment_from' => 'required|date',
            'date.enrollment_from_time' => 'required|date_format:H:i',
            'date.enrollment_to' => 'required|date',
            'date.enrollment_to_time' => 'required|date_format:H:i',
            'date.withdraw_date' => 'required|date',
            'date.withdraw_time' => 'required|date_format:H:i',
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
            'enrollment_start' => DateFormatter::getDatetimeFromDateAndTime($data['enrollment_from'],
                $data['enrollment_from_time']),
            'enrollment_end' => DateFormatter::getDatetimeFromDateAndTime($data['enrollment_to'],
                $data['enrollment_to_time']),
            'withdraw_end' => DateFormatter::getDatetimeFromDateAndTime($data['withdraw_date'], $data['withdraw_time']),
        ];
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
            $userEmails = $this->userRepository->getUsersEmailsAndLocaleByIds($userIds);
            $this->emailFacade->sendFreeSpotNotificationToSubstitutes($date, $userEmails);

            return;
        }

        $firstSubstituteEnrollment = $this->enrollmentRepository->getFirstSubstituteEnrolled($date->id);
        $firstSubstituteEnrollment->state = EnrollmentStates::SIGNED;
        $firstSubstituteEnrollment->save();

        $this->emailFacade->sendFreeSpotNotificationToSubstitutes($date, $firstSubstituteEnrollment->user);
    }
}
