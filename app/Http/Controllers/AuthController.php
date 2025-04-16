<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse{
        return $this->authService->signUp($request->toDTO());
    }

    public function login(LoginRequest $request): JsonResponse{
        return $this->authService->signIn($request->toDTO());
    }

    public function logout(): JsonResponse {
        return $this->authService->signOut();
    }
}
