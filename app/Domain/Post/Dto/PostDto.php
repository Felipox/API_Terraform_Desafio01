<?php

namespace App\Domain\Post\Dto;

use App\Domain\Post\PostStatus;
use DateTime;

class PostDto
{
    public function __construct(
        
        public readonly ?string $id,
        public readonly string $title,    
        public readonly string $content,
        public readonly string $author_id,
        public readonly PostStatus $status,
        public readonly ?DateTime $created_at,
        public readonly ?DateTime $updated_at,
        public readonly ?DateTime $deleted_at,

        )
    {}
    
    public static function fromArray(array $data): self
    {

        return new self(
            id: $data['id'] ?? null,
            title: $data['title'],
            content: $data['content'],
            author_id: $data['author_id'],
            status: PostStatus::from($data['status']),
            created_at: isset($data['created_at']) ? new \DateTime($data['created_at']) : null,
            updated_at: isset($data['updated_at']) ? new \DateTime($data['updated_at']) : null,
            deleted_at: isset($data['deleted_at']) ? new \DateTime($data['deleted_at']) : null,

        );

    }

    public function toArray(): array
    {
        return[
            'id'=>$this->id,
            'title'=>$this->title,
            'content'=>$this->content,
            'author_id'=>$this->author_id,
            'status'=>$this->status->value,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'delete_at'=>$this->deleted_at
        ];
        
    }
}