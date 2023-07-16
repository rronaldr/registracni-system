<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\User;

class UserRepository {

    public function getByXname(string $xname): ?User
    {
        /** @var \App\Models\User $user */
        $user =  User::query()
            ->where('xname', $xname)
            ->first();

        return $user;
    }

}
