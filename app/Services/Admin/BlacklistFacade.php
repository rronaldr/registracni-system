<?php

declare(strict_types = 1);

namespace App\Services\Admin;

use App\Models\Blacklist;
use App\Repositories\BlacklistRepository;
use App\Services\Admin\UserFacade;
use Carbon\Carbon;
use function trim;

class BlacklistFacade
{
    private BlacklistRepository $blacklistRepository;
    private UserFacade $userFacade;

    public function __construct(BlacklistRepository $blacklistRepository, UserFacade $userFacade)
    {
        $this->blacklistRepository = $blacklistRepository;
        $this->userFacade = $userFacade;
    }

    public function getGlobalBlacklist(): Blacklist
    {
        $blacklist = $this->blacklistRepository->getGlobalBlacklist();

        return $blacklist;
    }

    public function getBlacklistById(int $id): Blacklist
    {
        return $this->blacklistRepository->getBlacklistById($id);
    }

    public function checkUserOnBlacklist(Blacklist $blacklist, int $userId): bool
    {
        return $this->blacklistRepository->checkUserOnBlacklist($blacklist, $userId);
    }

    public function addUsersToBlacklist(int $blacklistId, array $data): void
    {
        $blacklist = $this->getBlacklistById($blacklistId);
        $dataCollection = collect($data);

        if (empty($dataCollection->get('users'))) {
            throw new \Exception('No xname values provided');
        }

        $delimiters = [",",";","\n"];
        $parsedData = str_replace($delimiters, $delimiters[0], $dataCollection->get('users'));

        $users = collect(explode(',', $parsedData));

        $users->each( function (string $xname) use ($blacklist, $dataCollection): void  {
            $user = $this->userFacade->getOrCreateUserByXname(trim($xname));

            if (!$this->checkUserOnBlacklist($blacklist, $user->id)) {
                $blacklist->users()->attach($user->id, [
                    'block_reason' => $dataCollection->get('block_reason'),
                    'blocked_until' => $dataCollection->get('blocked_until') !== null
                                        ? Carbon::parse($dataCollection->get('blocked_until'))
                                        : null
                ]);
            }

        });
    }

    public function createBlacklist(): Blacklist
    {
        return Blacklist::create();
    }

    /**
     * @throws \Exception
     */
    public function removeUserFromBlacklist(int $id, int $userId): void
    {
        $blacklist = $this->getBlacklistById($id);
        $user = $this->userFacade->getUserById($userId);

        if (!isset($user)) {
            throw new \Exception('User not found');
        }

        $blacklist->users()->detach($user->id);
    }

}
