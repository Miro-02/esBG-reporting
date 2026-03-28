<?php

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Requests\LoginRequest;
use Modules\Auth\Requests\RegisterRequest;
use Modules\Auth\Services\LoginService;
use Modules\Auth\Services\RegisterService;
use Modules\Auth\Services\LogoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\Requests\ForgotPasswordRequest;
use Modules\Auth\Requests\ResetPasswordRequest;
use Modules\Auth\Services\ForgotPasswordService;
use Modules\Auth\Services\ResetPasswordService;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Verified;
use Modules\User\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterService $registerService): JsonResponse
    {
        $result = $registerService->handle($request->validated());

        return response()->json($result, 201);
    }

    public function login(LoginRequest $request, LoginService $loginService): JsonResponse
    {
        $result = $loginService->handle($request->validated());

        if (!$result) {
            // Check if user exists but email is not verified
            $user = User::where('email', $request->email)->first();
            if ($user && !$user->hasVerifiedEmail()) {
                return response()->json([
                    'message' => 'Please verify your email before logging in'
                ], 403);
            }
            
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json($result);
    }

    public function logout(Request $request, LogoutService $logoutService): JsonResponse
    {
        $logoutService->handle($request->user());

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request, ForgotPasswordService $service)
    {
        $status = $service->handle($request->validated());
        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPasswordService $service, $token)
    {
        $status = $service->handle($request->validated(), $token);
        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    }

    public function verifyEmail(Request $request, $id, $hash): JsonResponse
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email verified successfully'], 200);
    }

    public function resendVerificationEmail(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email sent'], 200);
    }
}