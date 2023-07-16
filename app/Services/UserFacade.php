<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class UserFacade
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCurrentUser(): ?Authenticatable
    {
        if (auth()->check()){
            return auth()->user();
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

}
