<?php

namespace App\Domain\Comment\Dto;

use DateTime;

class CommentDto
{
    public function __construct(
        
        public readonly ?string $id,
        public readonly string $post_id,    
        public readonly string $author_id,
        public readonly string $content,
        public readonly ?DateTime $created_at,
        public readonly ?DateTime $updated_at,
        public readonly ?DateTime $deleted_at,

        )
    {}
    
    public static function fromArray(array $data): self
    {

        return new self(
            id: $data['id'] ?? null,
            post_id: $data['post_id'],
            author_id: $data['author_id'],
            content: $data['content'],
            created_at: isset($data['created_at']) ? new \DateTime($data['created_at']) : null,
            updated_at: isset($data['updated_at']) ? new \DateTime($data['updated_at']) : null,
            deleted_at: isset($data['deleted_at']) ? new \DateTime($data['deleted_at']) : null,

        );

    }

    public function toArray(): array
    {
        return[
            'id'=>$this->id,
            'post_id'=>$this->post_id,
            'author_id'=>$this->author_id,
            'content'=>$this->content,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'delete_at'=>$this->deleted_at
        ];
        
    }
}