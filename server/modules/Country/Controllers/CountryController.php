<?php

namespace Modules\Country\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Country\Models\Country;

class CountryController extends Controller
{
    /**
     * Get all countries as dropdown options
     */
    public function index(): JsonResponse
    {
        $countries = Country::select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json($countries);
    }
}
