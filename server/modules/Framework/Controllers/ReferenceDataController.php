<?php

namespace Modules\Framework\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Country\Models\Country;
use Modules\Sector\Models\Sector;
use Modules\Framework\Models\LegalForm;
use Modules\Framework\Models\Framework;
use Modules\Framework\Models\Certification;
use Modules\Framework\Models\CdpLevel;
use Modules\Framework\Models\EcoVadisRating;

class ReferenceDataController extends Controller
{
    /**
     * Get all reference data for dropdowns
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'countries' => Country::all(['id', 'code', 'name']),
            'sectors' => Sector::all(['id', 'code', 'name']),
            'legal_forms' => LegalForm::all(['id', 'code', 'name']),
            'frameworks' => Framework::all(['id', 'code', 'name']),
            'certifications' => Certification::all(['id', 'code', 'name']),
            'cdp_levels' => CdpLevel::all(['id', 'code', 'name']),
            'ecoVadis_ratings' => EcoVadisRating::all(['id', 'code', 'name']),
        ]);
    }

    /**
     * Get countries
     */
    public function countries(): JsonResponse
    {
        return response()->json(Country::all(['id', 'code', 'name']));
    }

    /**
     * Get sectors
     */
    public function sectors(): JsonResponse
    {
        return response()->json(Sector::all(['id', 'code', 'name']));
    }

    /**
     * Get legal forms
     */
    public function legalForms(): JsonResponse
    {
        return response()->json(LegalForm::all(['id', 'code', 'name']));
    }

    /**
     * Get frameworks
     */
    public function frameworks(): JsonResponse
    {
        return response()->json(Framework::all(['id', 'code', 'name']));
    }

    /**
     * Get certifications
     */
    public function certifications(): JsonResponse
    {
        return response()->json(Certification::all(['id', 'code', 'name']));
    }

    /**
     * Get CDP levels
     */
    public function cdpLevels(): JsonResponse
    {
        return response()->json(CdpLevel::all(['id', 'code', 'name']));
    }

    /**
     * Get EcoVadis ratings
     */
    public function ecoVadisRatings(): JsonResponse
    {
        return response()->json(EcoVadisRating::all(['id', 'code', 'name']));
    }
}
