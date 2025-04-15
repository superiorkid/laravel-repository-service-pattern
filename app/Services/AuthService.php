<?php

namespace App\Services;

use App\DTO\SignInDTO;
use App\DTO\SignUpDTO;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService {
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signUp(SignUpDTO $signUpDTO): JsonResponse
    {
        $user = $this->userRepository->findByEmail($signUpDTO->email);
        if ($user) {
            return response()
                ->json(["success" => false, "message" => "User already exists"], 409);
        }

        try {
            $hashedPassword = Hash::make($signUpDTO->password);
            $signUpDTO->password = $hashedPassword;

            $this->userRepository->save($signUpDTO);

            return response()->json(["success" => true, "message" => "Sign up successfully"], 201);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function signIn(SignInDTO $signInDTO): JsonResponse {
        $user = $this->userRepository->findByEmail($signInDTO->email);

        if (!$user || !Hash::check($signInDTO->password, $user->password)) {
            return response()->json(["success" => false, "message" => "Invalid Credentials"], 401);
        }

        try {
            $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
            return response()->json(["success" => true, "message" => "Sign in to your account", "data" => ["access_token" => $token]], 201);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function signOut(): JsonResponse {
        try {
            auth()->user()->tokens()->delete();
            return response()->json(["success" => true, "message" => "Logged out successfully"], 200);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }
}
