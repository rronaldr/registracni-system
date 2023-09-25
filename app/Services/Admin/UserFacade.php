<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Repositories\UserRepository;

class UserFacade
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getCurrentUser(): ?User
    {
        if (auth()->check()){
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

    public function getUserForEmail(int $id): User
    {
        return $this->userRepository->getUserForEmail($id);
    }

    public function getUserById(int $id): User
    {
        return $this->userRepository->getUserById($id);
    }
}
