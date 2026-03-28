<?php

namespace Modules\Auth\Services;

use Modules\User\Models\User;

class LogoutService
{
    public function handle(User $user): void
    {
        // Revoke current token
        $user->currentAccessToken()->delete();
        
        // Or revoke all tokens
        // $user->tokens()->delete();
    }
}