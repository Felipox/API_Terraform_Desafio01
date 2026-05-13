<?php

namespace App\Domain\Users;

use App\Domain\Users\Dto\UserDto;


Interface UserRepositoryInterface
{
    public function create(array $data): UserDto;
    public function findById(string $id): UserDto;
    public function findByEmail(string $email): UserDto;
    public function createToken(string $id): string;
}

?>