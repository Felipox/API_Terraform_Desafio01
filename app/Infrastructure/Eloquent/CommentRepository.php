<?php

namespace App\Infrastructure\Eloquent;

use App\Domain\Comment\Dto\CommentDto;
use App\Domain\Comment\CommentRepositoryInterface;
use App\Models\Comment;


class CommentRepository implements CommentRepositoryInterface
{

    public function __construct(private Comment $model) {}

    public function findbyId(string $id): CommentDto
    {
        $comment = $this->model->findOrFail($id);
        return CommentDto::fromArray($comment->toArray());
    }
    public function listComments(string $post_id): array
    {
        $comment = $this->model->where('post_id', $post_id)->get();
        return $comment->toArray();
    }
    public function create(CommentDto $data): CommentDto
    {
        $comment = $this->model->create($data->toArray());
        return CommentDto::fromArray($comment->toArray());
    }
    public function delete(string $id): void
    {
        $comment = $this->model->findOrFail($id);
        $comment->delete();
    }
}
