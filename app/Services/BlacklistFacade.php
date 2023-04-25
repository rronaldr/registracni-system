<?php

declare(strict_types = 1);

namespace App\Services;

use App\Repositories\BlacklistRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BlacklistFacade
{
    private BlacklistRepository $blacklistRepository;

    public function __construct(BlacklistRepository $blacklistRepository)
    {
        $this->blacklistRepository = $blacklistRepository;
    }

    public function getGlobalBlacklist(): Collection
    {
        $blacklist = $this->blacklistRepository->getGlobalBlacklist();

        return collect(json_decode($blacklist->data));
    }

    public function getBlacklistJsonFromResponse(string $data): Collection
    {
        $values = Str::of($data)->explode(',');

        $blacklistData = collect($values)
            ->filter(fn($block) => $block !== '')
            ->map(function(string $block): Collection
            {
                $stringSanitized = str_replace(["\r", "\n"], '', $block);
                $blacklistData = Str::of($stringSanitized)->explode(';');
                $blacklistCollection = collect(['email' => $blacklistData[0]]);

                if(isset($blacklistData[1])){
                    $date = Carbon::create($blacklistData[1])->toDateTimeString();
                    $blacklistCollection->put('blocked_until', $date);
                }

                if (isset($blacklistData[2]))
                {
                    $blacklistCollection->put('blocked_reason', $blacklistData[2]);
                }

                return $blacklistCollection;
            });
        return $blacklistData;
    }

}
