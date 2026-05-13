<?php
namespace App\Infrastructure\Eloquent;

use App\Domain\Post\Dto\PostDto;
use App\Domain\Post\PostRepositoryInterface;
use App\Models\Post;
use App\Domain\Post\PostStatus;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(protected Post $model){}

    public function findbyId (string $id): PostDto{
        $post =$this->model->findOrFail($id);
        return PostDto::fromArray($post->toArray());
    }
    public function listPublish(): array{
        $posts = $this->model->where('status',PostStatus::PUBLISHED->value)->get();
        return $posts->toArray();
    }
    public function create(PostDto $data): PostDto{
        $post = $this->model->create($data->toArray());
        return PostDto::fromArray($post->toArray());
    }
    public function update(string $id, PostDto $data): PostDto{
        $post = $this->model->findOrFail($id);
        $post->update($data->toArray());
        return PostDto::fromArray($post->toArray());
    }
    public function delete(string $id): void{
        $post = $this->model->findOrFail($id);
        $post->delete();
    }
    public function archivePost(string $id): PostDto{
       $this->model->where('id', $id)->update([
        'status' => PostStatus::ARCHIVED->value
        ]);
        $post = $this->model->findOrFail($id);
        return PostDto::fromArray($post->toArray());
    }
}



?>