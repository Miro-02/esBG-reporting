<?php

namespace Modules\Reports\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ReportPdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Modules\Reports\Models\Report;
use Modules\Reports\Requests\StoreReportRequest;
use Modules\Reports\Requests\UpdateReportMetadataRequest;
use Modules\Reports\Requests\StoreReportSection1Request;
use Modules\Reports\Requests\StoreReportSection2Request;
use Modules\Reports\Requests\StoreReportSection3Request;
use Modules\Reports\Requests\StoreReportSection4Request;
use Modules\Reports\Requests\StoreReportSection5Request;
use Modules\Reports\Requests\StoreReportSection6Request;
use Modules\Reports\Requests\StoreReportSection7Request;
use Modules\Reports\Requests\UpdateReportSection1Request;
use Modules\Reports\Requests\UpdateReportSection2Request;
use Modules\Reports\Requests\UpdateReportSection3Request;
use Modules\Reports\Requests\UpdateReportSection4Request;
use Modules\Reports\Requests\UpdateReportSection5Request;
use Modules\Reports\Requests\UpdateReportSection6Request;
use Modules\Reports\Requests\UpdateReportSection7Request;
use Modules\Reports\Resources\ReportResource;
use Modules\Reports\Services\ReportService;

class ReportController extends Controller
{
    private ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Get all reports for the authenticated user
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $reports = Report::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return ReportResource::collection($reports);
    }

    /**
     * Create a new report with metadata only
     */
    public function store(StoreReportRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $report = $this->reportService->createReport([
                'user_id' => $request->user()->id,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'start_date' => $validatedData['start_date'] ?? null,
                'end_date' => $validatedData['end_date'] ?? null,
            ]);

            return response()->json([
                'message' => 'Report created successfully',
                'data' => new ReportResource($report),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create report',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get a single report with all sections
     */
    public function show(Request $request, Report $report): JsonResponse
    {
        // Check if user owns this report
        if ($report->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $report = $this->reportService->loadAllRelations($report);

        return response()->json([
            'data' => new ReportResource($report),
        ]);
    }

    /**
     * Update report metadata
     */
    public function updateMetadata(UpdateReportMetadataRequest $request, Report $report): JsonResponse
    {
        try {
            // Check if user owns this report
            if ($report->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }

            $validatedData = $request->validated();

            $this->reportService->updateReportMetadata($report, $validatedData);

            $report = $this->reportService->loadAllRelations($report);

            return response()->json([
                'message' => 'Report metadata updated successfully',
                'data' => new ReportResource($report),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update report metadata',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update Section 1: Company Profile
     */
    public function updateSection1(StoreReportSection1Request $request, Report $report): JsonResponse
    {
        return $this->updateSection($request, $report, 1);
    }

    /**
     * Update Section 2: Governance
     */
    public function updateSection2(StoreReportSection2Request $request, Report $report): JsonResponse
    {
        return $this->updateSection($request, $report, 2);
    }

    /**
     * Update Section 3: Environment
     */
    public function updateSection3(StoreReportSection3Request $request, Report $report): JsonResponse
    {
        return $this->updateSection($request, $report, 3);
    }

    /**
     * Update Section 4: Social
     */
    public function updateSection4(StoreReportSection4Request $request, Report $report): JsonResponse
    {
        return $this->updateSection($request, $report, 4);
    }

    /**
     * Update Section 5: Cybersecurity
     */
    public function updateSection5(StoreReportSection5Request $request, Report $report): JsonResponse
    {
        return $this->updateSection($request, $report, 5);
    }

    /**
     * Update Section 6: Supply Chain
     */
    public function updateSection6(StoreReportSection6Request $request, Report $report): JsonResponse
    {
        return $this->updateSection($request, $report, 6);
    }

    /**
     * Update Section 7: Targets
     */
    public function updateSection7(StoreReportSection7Request $request, Report $report): JsonResponse
    {
        return $this->updateSection($request, $report, 7);
    }

    /**
     * Helper method to update a section
     */
    private function updateSection(Request $request, Report $report, int $sectionNumber): JsonResponse
    {
        try {
            // Check if user owns this report
            if ($report->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }

            $validatedData = $request->validated();

            $this->reportService->updateSection($report, $sectionNumber, $validatedData);

            $report = $this->reportService->loadAllRelations($report);

            return response()->json([
                'message' => "Report section {$sectionNumber} updated successfully",
                'data' => new ReportResource($report),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Failed to update section {$sectionNumber}",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update frameworks for a report
     */
    public function updateFrameworks(Request $request, Report $report): JsonResponse
    {
        try {
            // Check if user owns this report
            if ($report->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }

            $validated = $request->validate([
                'frameworks' => 'nullable|array',
                'frameworks.*' => 'integer|exists:frameworks,id',
            ]);

            if (isset($validated['frameworks'])) {
                $this->reportService->updateFrameworks($report, $validated['frameworks']);
            }

            $report = $this->reportService->loadAllRelations($report);

            return response()->json([
                'message' => 'Report frameworks updated successfully',
                'data' => new ReportResource($report),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update frameworks',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update certifications for a report
     */
    public function updateCertifications(Request $request, Report $report): JsonResponse
    {
        try {
            // Check if user owns this report
            if ($report->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }

            $validated = $request->validate([
                'certifications' => 'nullable|array',
                'certifications.*' => 'integer|exists:certifications,id',
            ]);

            if (isset($validated['certifications'])) {
                $this->reportService->updateCertifications($report, $validated['certifications']);
            }

            $report = $this->reportService->loadAllRelations($report);

            return response()->json([
                'message' => 'Report certifications updated successfully',
                'data' => new ReportResource($report),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update certifications',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a report
     */
    public function destroy(Request $request, Report $report): JsonResponse
    {
        try {
            // Check if user owns this report
            if ($report->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }

            $this->reportService->deleteReport($report);

            return response()->json([
                'message' => 'Report deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete report',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate and download PDF for a report
     */
    public function generatePdf(Request $request, Report $report, ReportPdfService $pdfService): SymfonyResponse
    {
        try {
            // Check if user owns this report
            if ($report->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }

            // Generate PDF
            $pdfContent = $pdfService->generatePdf($report);
            $fileName = $pdfService->getFileName($report);

            // Return PDF as download
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to generate PDF',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
