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
use Modules\Reports\Requests\UpdateReportRequest;
use Modules\Reports\Resources\ReportResource;

class ReportController extends Controller
{
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
     * Create a new report with all sections
     */
    public function store(StoreReportRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            
            // Create report with metadata
            $report = Report::create([
                'user_id' => $request->user()->id,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'start_date' => $validatedData['start_date'] ?? null,
                'end_date' => $validatedData['end_date'] ?? null,
            ]);

            // Create Section 1: Company Profile
            if (isset($validatedData['section1'])) {
                $report->section1()->create($validatedData['section1']);
            }

            // Create Section 2: Governance
            if (isset($validatedData['section2'])) {
                $report->section2()->create($validatedData['section2']);
            }

            // Create Section 3: Environment
            if (isset($validatedData['section3'])) {
                $report->section3()->create($validatedData['section3']);
            }

            // Create Section 4: Social
            if (isset($validatedData['section4'])) {
                $report->section4()->create($validatedData['section4']);
            }

            // Create Section 5: Cybersecurity
            if (isset($validatedData['section5'])) {
                $report->section5()->create($validatedData['section5']);
            }

            // Create Section 6: Supply Chain
            if (isset($validatedData['section6'])) {
                $report->section6()->create($validatedData['section6']);
            }

            // Create Section 7: Targets
            if (isset($validatedData['section7'])) {
                $report->section7()->create($validatedData['section7']);
            }

            // Attach frameworks and certifications
            if (isset($validatedData['frameworks'])) {
                $report->frameworks()->sync($validatedData['frameworks']);
            }

            if (isset($validatedData['certifications'])) {
                $report->certifications()->sync($validatedData['certifications']);
            }

            $report->load('section1', 'section2', 'section3', 'section4', 'section5', 'section6', 'section7', 'frameworks', 'certifications');

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

        $report->load('section1', 'section2', 'section3', 'section4', 'section5', 'section6', 'section7', 'frameworks', 'certifications');

        return response()->json([
            'data' => new ReportResource($report),
        ]);
    }

    /**
     * Update a report with all sections
     */
    public function update(UpdateReportRequest $request, Report $report): JsonResponse
    {
        try {
            // Check if user owns this report
            if ($report->user_id !== $request->user()->id) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }

            $validatedData = $request->validated();

            // Update report metadata
            $report->update([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'start_date' => $validatedData['start_date'] ?? null,
                'end_date' => $validatedData['end_date'] ?? null,
            ]);

            // Update or create Section 1
            if (isset($validatedData['section1'])) {
                $report->section1()->updateOrCreate(
                    ['report_id' => $report->id],
                    $validatedData['section1']
                );
            }

            // Update or create Section 2
            if (isset($validatedData['section2'])) {
                $report->section2()->updateOrCreate(
                    ['report_id' => $report->id],
                    $validatedData['section2']
                );
            }

            // Update or create Section 3
            if (isset($validatedData['section3'])) {
                $report->section3()->updateOrCreate(
                    ['report_id' => $report->id],
                    $validatedData['section3']
                );
            }

            // Update or create Section 4
            if (isset($validatedData['section4'])) {
                $report->section4()->updateOrCreate(
                    ['report_id' => $report->id],
                    $validatedData['section4']
                );
            }

            // Update or create Section 5
            if (isset($validatedData['section5'])) {
                $report->section5()->updateOrCreate(
                    ['report_id' => $report->id],
                    $validatedData['section5']
                );
            }

            // Update or create Section 6
            if (isset($validatedData['section6'])) {
                $report->section6()->updateOrCreate(
                    ['report_id' => $report->id],
                    $validatedData['section6']
                );
            }

            // Update or create Section 7
            if (isset($validatedData['section7'])) {
                $report->section7()->updateOrCreate(
                    ['report_id' => $report->id],
                    $validatedData['section7']
                );
            }

            // Sync frameworks and certifications
            if (isset($validatedData['frameworks'])) {
                $report->frameworks()->sync($validatedData['frameworks']);
            }

            if (isset($validatedData['certifications'])) {
                $report->certifications()->sync($validatedData['certifications']);
            }

            $report->load('section1', 'section2', 'section3', 'section4', 'section5', 'section6', 'section7', 'frameworks', 'certifications');

            return response()->json([
                'message' => 'Report updated successfully',
                'data' => new ReportResource($report),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update report',
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

            $report->delete();

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
