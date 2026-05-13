<?php

namespace App\Domain\Post;

use App\Domain\Post\Dto\PostDto;

interface PostRepositoryInterface
{

public function findbyId (string $id): PostDto;
public function listPublish(): array;
public function create(PostDto $data): PostDto;
public function update(string $id, PostDto $data): PostDto;
public function delete(string $id): void;
public function archivePost(string $id): PostDto;


}



?>