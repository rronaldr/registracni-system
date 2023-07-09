<?php

declare(strict_types = 1);



namespace App\Repositories;

use App\Models\Blacklist;

class BlacklistRepository
{

    /** @returns  \App\Models\Blacklist **/
    public function getGlobalBlacklist(): ?Blacklist
    {
        /** @todo rework global blacklist */
        return Blacklist::query()
            ->where('id',1)
            ->first();
    }
}
