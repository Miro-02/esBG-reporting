<?php

namespace Modules\Reports\Services;

use Modules\Reports\Models\Report;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * Create a new report with metadata and optionally all sections.
     */
    public function createReport(array $metadata, array $sections = [], array $frameworks = [], array $certifications = []): Report
    {
        $report = Report::create($metadata);

        if (!empty($sections)) {
            $this->createSections($report, $sections);
        }

        if (!empty($frameworks)) {
            $report->frameworks()->sync($frameworks);
        }

        if (!empty($certifications)) {
            $report->certifications()->sync($certifications);
        }

        return $report->load('section1', 'section2', 'section3', 'section4', 'section5', 'section6', 'section7', 'frameworks', 'certifications');
    }

    /**
     * Update report metadata.
     */
    public function updateReportMetadata(Report $report, array $metadata): Report
    {
        $report->update($metadata);
        return $report;
    }

    /**
     * Update a specific section of a report.
     */
    public function updateSection(Report $report, int $sectionNumber, array $data): Report
    {
        $relationName = "section{$sectionNumber}";
        
        if (!method_exists($report, $relationName)) {
            throw new \InvalidArgumentException("Section {$sectionNumber} does not exist");
        }

        $report->{$relationName}()->updateOrCreate(
            ['report_id' => $report->id],
            $data
        );

        return $report->load($relationName);
    }

    /**
     * Create all sections for a report.
     */
    public function createSections(Report $report, array $sections): void
    {
        for ($i = 1; $i <= 7; $i++) {
            $sectionKey = "section{$i}";
            
            if (isset($sections[$sectionKey])) {
                $relationName = "section{$i}";
                $report->{$relationName}()->create($sections[$sectionKey]);
            }
        }
    }

    /**
     * Update frameworks for a report.
     */
    public function updateFrameworks(Report $report, array $frameworks): void
    {
        $report->frameworks()->sync($frameworks);
    }

    /**
     * Update certifications for a report.
     */
    public function updateCertifications(Report $report, array $certifications): void
    {
        $report->certifications()->sync($certifications);
    }

    /**
     * Delete a report.
     */
    public function deleteReport(Report $report): bool
    {
        return $report->delete();
    }

    /**
     * Load all report relationships.
     */
    public function loadAllRelations(Report $report): Report
    {
        return $report->load('section1', 'section2', 'section3', 'section4', 'section5', 'section6', 'section7', 'frameworks', 'certifications');
    }
}
