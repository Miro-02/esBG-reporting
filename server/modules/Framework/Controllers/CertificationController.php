<?php

namespace Modules\Framework\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Framework\Models\Certification;
use Modules\Framework\Models\LegalForm;
use Modules\Framework\Models\CdpLevel;
use Modules\Framework\Models\EcoVadisRating;

class CertificationController extends Controller
{
    /**
     * Get all certifications as dropdown options
     */
    public function certifications(): JsonResponse
    {
        $certifications = Certification::select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json($certifications);
    }

    /**
     * Get all legal forms as dropdown options
     */
    public function legalForms(): JsonResponse
    {
        $legalForms = LegalForm::select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json($legalForms);
    }

    /**
     * Get all CDP levels as dropdown options
     */
    public function cdpLevels(): JsonResponse
    {
        $cdpLevels = CdpLevel::select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json($cdpLevels);
    }

    /**
     * Get all EcoVadis ratings as dropdown options
     */
    public function ecoVadisRatings(): JsonResponse
    {
        $ecoVadisRatings = EcoVadisRating::select('id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return response()->json($ecoVadisRatings);
    }
}
