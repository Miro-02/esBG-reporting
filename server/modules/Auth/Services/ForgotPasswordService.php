<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Password;

class ForgotPasswordService
{
    public function handle(array $data): string
    {
        $status = Password::broker()->sendResetLink(
            ['email' => $data['email']],
            function ($user, $token) use ($data) {
                $user->sendPasswordResetNotification($token);
            }
        );
        return $status;
    }
}
