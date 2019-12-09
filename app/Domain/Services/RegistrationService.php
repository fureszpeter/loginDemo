<?php

namespace App\Domain\Services;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(string $name, string $username, string $email, string $password): User
    {
        $user = new User(
            $name,
            $username,
            $email,
            Hash::make($password)
        );

        return $this->userRepository->save($user);
    }
}
