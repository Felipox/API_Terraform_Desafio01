<?php

namespace App\Services;

use App\Domain\Users\Dto\UserDto;
use App\Domain\Users\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function __construct(private UserRepositoryInterface $userRepository) {}


    public function show(string $id): UserDto
    {

        return $this->userRepository->findById($id);
    }
}
