<?php

namespace App\Policies;

use App\Enums\EnrollmentStates;
use App\Enums\Roles;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;


    public function view(User $user, Event $event): bool
    {
        $collaborations = $event->collaborators()->pluck('user_id');

        return $user->id === $event->author->id || $collaborations->contains($user->id);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(Roles::STAFF, Roles::EDITOR);
    }

    public function delete(User $user, int $id): bool
    {
        $event = Event::query()
            ->where('id', $id)
            ->withCount(['enrollments' => function($q) {
                $q->where('state', EnrollmentStates::SIGNED);
            }])
            ->first();

        return $event->enrollments_count === 0;
    }
}
