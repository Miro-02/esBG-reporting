<?php

namespace Modules\Reports\Services;

use Modules\Reports\Models\Report;
use Modules\Reports\Data\ImportResult;
use Modules\Framework\Models\Framework;
use Modules\Framework\Models\Certification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportBatchService
{
    public function __construct(
        private ReportService $reportService
    ) {}

    /**
     * Create reports from validated row data
     * 
     * @param array $validatedRows Array of validated row data
     * @param int $userId User ID to assign reports to
     * @return ImportResult
     */
    public function createReportsFromValidatedRows(array $validatedRows, int $userId): ImportResult
    {
        $result = new ImportResult(count($validatedRows));

        foreach ($validatedRows as $rowIndex => $rowData) {
            try {
                $rowNumber = $rowIndex + 2; // +2 because 1 = header, 0-indexed array

                // Extract frameworks and certifications before passing to report service
                $frameworks = isset($rowData['frameworks']) 
                    ? $this->resolveFrameworkIds($rowData['frameworks']) 
                    : [];
                
                $certifications = isset($rowData['certifications']) 
                    ? $this->resolveCertificationIds($rowData['certifications']) 
                    : [];

                // Prepare metadata
                $metadata = [
                    'user_id' => $userId,
                    'name' => $rowData['name'],
                    'description' => $rowData['description'] ?? null,
                    'start_date' => $rowData['start_date'],
                    'end_date' => $rowData['end_date'],
                ];

                // Prepare section data
                $sections = $this->prepareSectionData($rowData);

                // Create report with transaction
                DB::beginTransaction();
                
                $report = $this->reportService->createReport(
                    $metadata,
                    $sections,
                    $frameworks,
                    $certifications
                );

                DB::commit();

                $result->addSuccess($report->id);

            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('Report import failed for row ' . $rowNumber, [
                    'row_data' => $rowData,
                    'error' => $e->getMessage(),
                ]);

                $result->addFailure(
                    $rowNumber,
                    [$e->getMessage()],
                    $rowData['name'] ?? 'Unknown'
                );
            }
        }

        return $result;
    }

    /**
     * Prepare section data from row by identifying section columns
     */
    private function prepareSectionData(array $rowData): array
    {
        $sections = [];

        // For each section, collect all columns that start with section_N_
        for ($i = 1; $i <= 7; $i++) {
            $sectionData = [];
            $prefix = "section_{$i}_";

            foreach ($rowData as $key => $value) {
                if (strpos($key, $prefix) === 0) {
                    // Remove the prefix and add to section data
                    $fieldName = substr($key, strlen($prefix));
                    if ($value !== null && $value !== '') {
                        $sectionData[$fieldName] = $value;
                    }
                }
            }

            if (!empty($sectionData)) {
                $sections["section{$i}"] = $sectionData;
            }
        }

        return $sections;
    }

    /**
     * Resolve framework names to IDs via exact string matching
     * 
     * @param string|array $frameworks Comma-separated or array of framework names
     * @return array Array of framework IDs
     */
    private function resolveFrameworkIds($frameworks): array
    {
        if (empty($frameworks)) {
            return [];
        }

        // Handle both comma-separated string and array
        $names = is_array($frameworks) 
            ? $frameworks 
            : array_map('trim', explode(',', $frameworks));

        $frameworkIds = [];

        foreach ($names as $name) {
            $name = trim($name);
            
            $framework = Framework::where('name', '=', $name)->first();
            
            if ($framework) {
                $frameworkIds[] = $framework->id;
            } else {
                Log::warning("Framework not found: {$name}");
            }
        }

        return $frameworkIds;
    }

    /**
     * Resolve certification names to IDs via exact string matching
     * 
     * @param string|array $certifications Comma-separated or array of certification names
     * @return array Array of certification IDs
     */
    private function resolveCertificationIds($certifications): array
    {
        if (empty($certifications)) {
            return [];
        }

        // Handle both comma-separated string and array
        $names = is_array($certifications) 
            ? $certifications 
            : array_map('trim', explode(',', $certifications));

        $certificationIds = [];

        foreach ($names as $name) {
            $name = trim($name);
            
            $certification = Certification::where('name', '=', $name)->first();
            
            if ($certification) {
                $certificationIds[] = $certification->id;
            } else {
                Log::warning("Certification not found: {$name}");
            }
        }

        return $certificationIds;
    }
}
