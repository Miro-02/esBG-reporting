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

        // Check if email is verified
        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return false;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ];
    }
}