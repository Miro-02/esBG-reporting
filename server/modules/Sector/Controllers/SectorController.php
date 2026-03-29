<?php

namespace Modules\Sector\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Sector\Models\Sector;

class SectorController extends Controller
{
    /**
     * Get all sectors as dropdown options
     */
    public function index(): JsonResponse
    {
        $sectors = Sector::select('id', 'name', 'nace_code')
            ->orderBy('name')
            ->get();

        return response()->json($sectors);
    }
}
