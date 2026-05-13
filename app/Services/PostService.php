<?php


namespace App\Services;

use App\Domain\Post\Dto\PostDto;
use App\Domain\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class PostService
{

    public function __construct(private PostRepositoryInterface $postRepository) {}

    public function create(PostDto $data): PostDto
    {
        return $this->postRepository->create($data);
    }
    public function List(): array
    {
        return $this->postRepository->listPublish();
    }
    public function ListId(string $id): PostDto
    {
        return $this->postRepository->findbyId($id);
    }
    public function update(string $id, PostDto $data)
    {
        $this->postRepository->findbyId($id);
        return $this->postRepository->update($id, $data);
    }
    public function delete(string $id): void
    {
        $this->postRepository->findbyId($id);
        $this->postRepository->delete($id);
    }
    public function archive(string $id): PostDto
    {
        $this->postRepository->findbyId($id);
        return $this->postRepository->archivePost($id);
    }
}
