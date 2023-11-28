<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{

    public function getUserById(int $id): ?User
    {
        /** @var \App\Models\User $user */
        $user = User::query()
            ->where('id', $id)
            ->first();

        return $user;
    }

    public function getByXname(string $xname): ?User
    {
        /** @var \App\Models\User $user */
        $user = User::query()
            ->where('xname', $xname)
            ->first();

        return $user;
    }

    public function getUserByEmail(string $email): ?User
    {
        /** @var \App\Models\User $user */
        $user = User::query()
            ->where('email', $email)
            ->first();

        return $user;
    }

    public function getUserForEmail(int $id): User
    {
        /** @var \App\Models\User $user */
        $user = User::query()
            ->select(['xname', 'first_name', 'last_name', 'email'])
            ->where('id', $id)
            ->first();

        return $user;
    }

    public function findUserByXnameOrEmail(string $search): ?User
    {
        /** @var User $user */
        $user = User::query()
            ->where('xname', 'LIKE', sprintf('%%%s%%', $search))
            ->orWhere('email', 'LIKE', sprintf('%%%s%%', $search))
            ->first();

        return $user;
    }

    public function findUserByAlumniId(int $id): ?User
    {
        /** @var User $user */
        $user = User::query()->where('absolvent_id', $id)->first();

        return $user;
    }

    public function getUsersEmailsAndLocaleByIds(array $userIds): Collection
    {
        return User::query()
            ->whereIn('id', $userIds)
            ->get(['email', 'locale']);
    }

}
