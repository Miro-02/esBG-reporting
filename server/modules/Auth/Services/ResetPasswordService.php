<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordService
{
    public function handle(array $data, string $token): string
    {
        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'token' => $token,
            ],
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
        return $status;
    }
}
