<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Blacklist;

class BlacklistRepository
{

    public function getGlobalBlacklist(): Blacklist
    {
        return Blacklist::query()
            ->where('id',1)
            ->first();
    }
}
