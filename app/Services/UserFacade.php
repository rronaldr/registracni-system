<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Roles;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UserFacade
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserForEmail(int $id): User
    {
        return $this->userRepository->getUserForEmail($id);
    }

    public function getCurrentUser(): ?User
    {
        if (auth()->check()) {
            $user = $this->userRepository->getUserById(auth()->user()->id);
            return $user;
        } else {
            return null;
        }
    }

    public function getUsersEmailsAndLocaleByIds(array $ids): Collection
    {
        return $this->userRepository->getUsersEmailsAndLocaleByIds($ids);
    }

    public function assignRolesToUserFromEntitlements(): void
    {
        $user = $this->getCurrentUser();

        if ($user === null) {
            return;
        }

        if ($user->hasRole(Roles::STUDENT) && !Str::contains($user->entitlement, 'student')) {
            $user->removeRole(Roles::STUDENT);
        }

        if ($user->hasRole(Roles::STAFF) && !Str::contains($user->entitlement, 'employee')) {
            $user->removeRole(Roles::STAFF);
        }

        // Assign role to alumni
        if ($user->absolvent_id !== null) {
            $user->assignRole(Roles::STUDENT);
        }

        // Assign role based on shibboleth entitlement
        if ($user->shibboleth_id !== null) {
            collect(explode(';', $user->entitlement))
                ->each(function (string $entitlement) use ($user): void {
                    switch ($entitlement) {
                        case 'student':
                            $user->assignRole(Roles::STUDENT);
                            break;
                        case 'employee':
                            $user->assignRole(Roles::STAFF);
                            break;
                    }
                });
        }

    }

    public function getOrCreateAlumni(Collection $userData): User
    {
        $user = $this->userRepository->findUserByAlumniId($userData->get('id'));

        if ($user !== null) {
            return $user;
        }

        $existingUserWithSameEmail = $this->userRepository->getUserByEmail($userData->get('email'));

        // Merge alumni user by email, if already exists as external user
        if ($existingUserWithSameEmail !== null) {
            $existingUserWithSameEmail->absolvent_id = $userData->get('id');
            $existingUserWithSameEmail->first_name = $userData->get('firstname');
            $existingUserWithSameEmail->last_name = $userData->get('lastname');
            $existingUserWithSameEmail->display_name = $userData->get('fullname');
            $existingUserWithSameEmail->save();

            return $existingUserWithSameEmail;
        }

        $user = new User();
        $user->absolvent_id = $userData->get('id');
        $user->first_name = $userData->get('firstname');
        $user->last_name = $userData->get('lastname');
        $user->display_name = $userData->get('fullname');
        $user->email = $userData->get('email');
        $user->save();

        return $user;
    }

}
