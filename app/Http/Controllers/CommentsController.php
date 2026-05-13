<?php

namespace App\Http\Controllers;

use App\Domain\Comment\Dto\CommentDto;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;


class CommentsController extends Controller
{
    public function __construct(private CommentService $commentService)
    {}
    public function index(string $post_id):JsonResponse
    {
        $comments = $this->commentService->show($post_id);
        return response()->json($comments,200);
    }
    public function create(CommentRequest $request):JsonResponse
    {
        $comment = $this->commentService->create(CommentDto::fromArray($request->validated()));
        return response()->json($comment->toArray(),201);
    }
    public function delete(string $id):JsonResponse
    {   
        $comment = $this->commentService->showId($id);
        $this->authorize('modify', $comment);
        $this->commentService->delete($id);
        return response()->json(null,201);
    }
    
}
