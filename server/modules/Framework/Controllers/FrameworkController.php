<?php

namespace Modules\Framework\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Framework\Models\Framework;

class FrameworkController extends Controller
{
    /**
     * Get all frameworks as dropdown options
     */
    public function index(): JsonResponse
    {
        $frameworks = Framework::select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json($frameworks);
    }
}
