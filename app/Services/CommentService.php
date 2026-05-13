<?php

namespace App\Services;

use App\Domain\Comment\Dto\CommentDto;
use App\Domain\Comment\CommentRepositoryInterface;


class CommentService
{

    public function __construct(private CommentRepositoryInterface $commentRepository) {}

    public function show(string $post_id): array 
    {
        return $this->commentRepository->listComments($post_id);
    }
    public function create(CommentDto $comment): CommentDto 
    {
        return $this->commentRepository->create($comment);
    }
    public function delete(string $id):void
    {
        $this->commentRepository->delete($id);
    }
    public function showId(string $id): CommentDto 
    {
        return $this->commentRepository->findbyId($id);
    }
    }
