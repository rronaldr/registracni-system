<?php

namespace App\Policies;

use App\Enums\EnrollmentStates;
use App\Enums\Event\EventUserGroups;
use App\Enums\Roles;
use App\Models\Blacklist;
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
        $now = Carbon::now('CET');
        $event = $date->event;
        $isEventBlacklisted = false;
        $isGlobalBlacklisted = false;

        if ($event->event_blacklist) {
            /** @var Blacklist $blacklist */
            $blacklist = $event->blacklist;

            $isEventBlacklisted = $blacklist->isUserOnBlacklist($user->id);
        }

        if ($event->global_blacklist) {
            $blacklist = Blacklist::find(1);

            $isGlobalBlacklisted = $blacklist->isUserOnBlacklist($user->id);
        }

        $isUserGroup = $this->checkUserBelongsToGroup($user, $event->user_group);

        return !$date->hasUserEnrolled($user->id)
            && ($date->getSignedCount() < $date->capacity || $date->capacity === -1)
            && $date->enrollment_start <= $now
            && $date->enrollment_end > $now
            && $isUserGroup
            && !$isEventBlacklisted
            && !$isGlobalBlacklisted;
    }

    public function substituteEnroll(User $user, Date $date): bool
    {
        $now = Carbon::now('CET');
        $event = $date->event;

        $isUserGroup = $this->checkUserBelongsToGroup($user, $event->user_group);

        return $date->capacity !== -1
            && (bool) $date->substitute === true
            && $date->getSignedCount() >= $date->capacity
            && $date->enrollment_start <= $now
            && $date->enrollment_end > $now
            && $isUserGroup
            && !$date->hasUserEnrolled($user->id);
    }

    public function signOff(User $user, Enrollment $enrollment): bool
    {
        return $enrollment->date->withdraw_end >= Carbon::now() && $enrollment->state !== EnrollmentStates::SIGNED_OFF;
    }

    private function checkUserBelongsToGroup(User $user, int $userGroup): bool
    {
        $belongsToUserGroup = false;

        switch($userGroup) {
            case EventUserGroups::EVERYONE:
                $belongsToUserGroup = true;
                break;
            case EventUserGroups::CURRENT_STUDENTS:
                $belongsToUserGroup = $user->hasRole(Roles::STUDENT);
                break;
            case EventUserGroups::GRADUATE:
                $belongsToUserGroup = !empty($user->absolvent_id);
                break;
            case EventUserGroups::STAFF:
                $belongsToUserGroup = $user->hasRole(Roles::STAFF);
                break;
            case EventUserGroups::ALL_STUDENTS:
                $belongsToUserGroup = $user->hasRole(Roles::STUDENT) || !empty($user->absolvent_id);
                break;
        }

        return $belongsToUserGroup;
    }
}
