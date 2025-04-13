<?php

namespace App\Repositories;

use App\DTO\SignUpDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository {
    public function findById(int $id): User | null {
        return User::query()->find($id);
    }

    public function findByEmail(string $email): User | null {
        return User::query()->where('email', $email)->first();
    }

    public function save(SignUpDTO $signUpDTO) {
        return User::query()->create([
            "name" => $signUpDTO->name,
            "email" => $signUpDTO->email,
            "password" => $signUpDTO->password,
        ]);
    }
}
