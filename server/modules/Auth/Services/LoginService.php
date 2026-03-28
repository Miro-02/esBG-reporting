<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function handle(array $credentials): array|false
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ];
    }
}