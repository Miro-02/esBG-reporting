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


}