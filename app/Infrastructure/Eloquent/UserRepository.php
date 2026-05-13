<?php

namespace App\Infrastructure\Eloquent;

use App\Domain\Users\Dto\UserDto;
use App\Domain\Users\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(protected User $model) {}

    public function create(array $data): UserDto
    {
        $user = $this->model->create($data);

        return UserDto::fromArray($user->toArray());
    }
    public function findById(string $id): UserDto
    {
        $user = $this->model->findOrFail($id);
        return UserDto::fromArray($user->toArray());
    }
    public function findByEmail(string $email): UserDto
    {
        $user = $this->model->where('email', $email)->first();
        return UserDto::fromArray($user->toArray());
    }
    public function createToken(string $id): string{
        $user = $this->model->findOrFail($id);
        $token = $user->createToken($user->name);
        return $token->plainTextToken;
    }
    
}
