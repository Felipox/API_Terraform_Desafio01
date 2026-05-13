<?php

namespace App\Http\Controllers;

use App\Domain\Post\Dto\PostDto;
use App\Http\Requests\PostRequest;
use App\Services\PostService;
use Symfony\Component\HttpFoundation\JsonResponse;


class PostsController extends Controller
{
   public function __construct(private PostService $postService)
   {}

   public function index():JsonResponse{
      
      $posts = $this->postService->List();
      return response()->json($posts,200);
   }
   public function show(string $id): JsonResponse
   {
      $post = $this->postService->ListId($id);
      return response()->json($post,200);
   }
   public function create(PostRequest $request):JsonResponse
   {
      $post = $this->postService->create(PostDto::fromArray($request->validated()));
      return response()->json($post,201);
   }
   public function update(string $id, PostRequest $request):JsonResponse
   {
      $post = $this->postService->ListId($id);
      $this->authorize('modify', $post);
      $post = $this->postService->update($id,PostDto::fromArray($request->validated()));
      return response()->json($post,200);
   }
   public function delete(string $id):JsonResponse
   {
      $post = $this->postService->ListId($id);
      $this->authorize('modify', $post);
      $this->postService->delete($id);
      return response()->json(["Message"=>'Deletado com Sucesso'],200);
   }
   public function archivePost(string $id):JsonResponse
   {
      $post = $this->postService->ListId($id);;
      $this->authorize('modify', $post);
      $post = $this->postService->archive($id);
      return response()->json($post,200);
   }
}
