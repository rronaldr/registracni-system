<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

class UserFacade
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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

    public function getOrCreateUserByXname(string $xname): User
    {
        $user = $this->userRepository->getByXname($xname);

        if (isset($user)) {
            return $user;
        }

        $user = new User();
        $user->xname = $xname;
        $user->save();

        return $user;
    }

    public function getOrCreateUserByEmail(string $email): User
    {
        $user = $this->userRepository->getUserByEmail($email);

        if (isset($user)) {
            return $user;
        }

        $user = new User();
        $user->email = $email;
        $user->save();

        return $user;
    }

    public function getUserForEmail(int $id): User
    {
        return $this->userRepository->getUserForEmail($id);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->getUserById($id);
    }

    public function findUserByXnameOrEmail(string $search): ?User
    {
        return $this->userRepository->findUserByXnameOrEmail($search);
    }

    public function assignRole(int $userId, int $roleId): void
    {
        $user = $this->getUserById($userId);
        $role = Role::query()->where('id', $roleId)->first();
        if (!isset($user)) {
            return;
        }

        $user->assignRole($role);
    }

    public function revokeRole(int $userId, int $roleId): void
    {
        $user = $this->getUserById($userId);
        $role = Role::query()->where('id', $roleId)->first();
        if (!isset($user)) {
            return;
        }

        $user->removeRole($role);
    }
}
