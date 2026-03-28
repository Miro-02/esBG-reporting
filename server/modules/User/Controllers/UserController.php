<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\User\Models\User;
use Modules\User\Requests\UpdateCompanyProfileRequest;
use Modules\User\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Get authenticated user's profile
     */
    public function profile(Request $request): UserResource
    {
        return new UserResource($request->user()->load('country', 'sector', 'legalForm', 'parentCompany'));
    }

    /**
     * Update user's company profile
     */
    public function updateProfile(UpdateCompanyProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        
        $validatedData = $request->validated();
        
        try {
            $user->update($validatedData);
            $user->load('country', 'sector', 'legalForm', 'parentCompany');
            
            return response()->json([
                'message' => 'Company profile updated successfully',
                'data' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update company profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
