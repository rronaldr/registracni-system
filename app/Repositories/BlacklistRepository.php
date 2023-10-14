<?php

declare(strict_types=1);


namespace App\Repositories;

use App\Models\Blacklist;

class BlacklistRepository
{

    /** @returns  \App\Models\Blacklist * */
    public function getGlobalBlacklist(): Blacklist
    {
        /** @var \App\Models\Blacklist $blacklist */
        $blacklist = Blacklist::query()
            ->where('id', 1)
            ->with(['users'])
            ->first();

        return $blacklist;
    }

    public function getBlacklistById(int $id): Blacklist
    {
        /** @var \App\Models\Blacklist $blacklist */
        $blacklist = Blacklist::query()
            ->where('id', $id)
            ->with(['users'])
            ->first();

        return $blacklist;
    }

    public function checkUserOnBlacklist(Blacklist $blacklist, int $userId): bool
    {
        $userCount = $blacklist->users()
            ->where('user_id', $userId)
            ->count();

        $hasUser = $userCount > 0 ? true : false;

        return $hasUser;
    }
}
