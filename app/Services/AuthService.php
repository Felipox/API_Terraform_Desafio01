<?php

namespace App\Services;

use App\Domain\Users\Dto\UserDto;
use App\Domain\Users\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function __construct(private UserRepositoryInterface $userRepository) {}


    public function register(UserDto $user): UserDto
    {

        $data = $user->toArray();
        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->create($data);
    }

    public function login(array $data): ?string
    {

        $user = $this->userRepository->findByEmail($data['email']);


        if (!Hash::check($data['password'], $user->password)) {

            return null;
        }



        return $this->userRepository->createToken($user->id);
    }
}
