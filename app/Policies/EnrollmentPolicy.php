<?php

namespace App\Policies;

use App\Enums\EnrollmentStates;
use App\Enums\Event\EventUserGroups;
use App\Enums\Roles;
use App\Models\Date;
use App\Models\Enrollment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnrollmentPolicy
{
    use HandlesAuthorization;

    public function enroll(User $user, Date $date): bool
    {
        $now = Carbon::now();
        $event = $date->event;

        $isUserGroup = false;

        switch($event->user_group) {
            case EventUserGroups::EVERYONE:
                $isUserGroup = true;
                break;
            case EventUserGroups::CURRENT_STUDENTS:
                $isUserGroup = $user->hasRole(Roles::STUDENT);
                break;
            case EventUserGroups::GRADUATE:
                $isUserGroup = !empty($user->absolvent_id);
                break;
            case EventUserGroups::STAFF:
                $isUserGroup = $user->hasRole(Roles::STAFF) || !empty($user->pasword);
                break;
            case EventUserGroups::ALL_STUDENTS:
                $isUserGroup = $user->hasRole(Roles::STUDENT) || !empty($user->absolvent_id);
                break;
        }

        return (!$date->hasUserEnrolled($user->id)
            && $date->getSignedCount() < $date->capacity
            && $date->enrollment_start <= $now
            && $date->enrollment_end > $now
            && $isUserGroup)
            || $this->substituteEnroll($user, $date);
    }

    public function substituteEnroll(User $user, Date $date): bool
    {
        return $date->capacity !== -1
            && $date->substitute === true
            && $date->getSignedCount() >= $date->capacity
            && $date->enrollment_end >= Carbon::now()
            && !$date->hasUserEnrolled($user->id);
    }

    public function signOff(User $user, Enrollment $enrollment): bool
    {
        return $enrollment->date->withdraw_end >= Carbon::now() && $enrollment->state !== EnrollmentStates::SIGNED_OFF;
    }

    public function before(User $user)
    {
        if ($user->hasRole(Roles::ADMIN)) {
            return true;
        }
    }
}
