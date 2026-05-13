<?php

namespace App\Http\Controllers;

use App\Domain\Users\Dto\UserDto;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(RegisterRequest $request)
    {

        $dto = UserDto::fromArray($request->validated());
        $user_dto = $this->authService->register($dto);
        $user_data = $user_dto->toArray();

        return response()->json([
            'Message' => 'Usuario criado com sucesso',
            'User' => $user_data['name'],
            'id' => $user_data['id']
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {

        $token = $this->authService->login($request->validated());

        if ($token === null) {
            return response()->json([
                'message' => 'credenciais erradas'
            ], 403);
        }

        return response()->json([
            'User' => $request->name,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['Messagem' => 'Logout realizado com sucesso'], 204);
    }
}
