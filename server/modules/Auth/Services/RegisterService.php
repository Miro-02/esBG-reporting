<?php

namespace Modules\Auth\Services;

use Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterService
{
    public function handle(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Send email verification notification
        event(new Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ];
    }
}