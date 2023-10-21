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

        if ($user === null || $user->shibboleth_id === null) {
            return;
        }

        if ($user->hasRole(Roles::STUDENT) && !Str::contains($user->entitlement, 'student')) {
            $user->removeRole(Roles::STUDENT);
        }

        if ($user->hasRole(Roles::STAFF) && !Str::contains($user->entitlement, 'staff')) {
            $user->removeRole(Roles::STAFF);
        }

        collect(explode(';', $user->entitlement))
            ->each(function (string $entitlement) use ($user): void {
                switch ($entitlement) {
                    case 'student':
                        $user->assignRole(Roles::STUDENT);
                        break;
                    case 'staff':
                        $user->assignRole(Roles::STAFF);
                        break;
                }
            });
    }

}
