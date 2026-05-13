<?php

namespace App\Domain\Comment;

use App\Domain\Comment\Dto\CommentDto;


interface CommentRepositoryInterface
{

public function findbyId (string $id): CommentDto;
public function listComments(string $post_id): array;
public function create(CommentDto $data): CommentDto;
public function delete(string $id):void;

}

?>