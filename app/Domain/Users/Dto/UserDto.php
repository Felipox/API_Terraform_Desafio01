<?php

namespace App\Domain\Users\Dto;

use DateTime;

class UserDto
{
    public function __construct(
        
        public readonly ?string $id,
        public readonly string $name,    
        public readonly string $email,
        public readonly string $password,
        public readonly ?DateTime $created_at,
        public readonly ?DateTime $updated_at,
        public readonly ?DateTime $deleted_at,

        )
    {}
    
    public static function fromArray(array $data): self
    {

        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            created_at: isset($data['created_at']) ? new \DateTime($data['created_at']) : null,
            updated_at: isset($data['updated_at']) ? new \DateTime($data['updated_at']) : null,
            deleted_at: isset($data['deleted_at']) ? new \DateTime($data['deleted_at']) : null,

        );

    }

    public function toArray(): array
    {
        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'password'=>$this->password,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'delete_at'=>$this->deleted_at
        ];
        
    }
        
    





}





?>