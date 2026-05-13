<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\UserService;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(private UserService $userService) {}

    public function index(Request $request): JsonResponse
    {
        $user = $request->user()->currentAccessToken();
        $dto =$this->userService->show($user->tokenable_id);

        return response()->json($dto->toArray(),200);
    }
}
