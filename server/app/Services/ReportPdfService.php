<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Modules\Reports\Models\Report;

class ReportPdfService
{
    /**
     * Generate a PDF for a report
     *
     * @param Report $report
     * @return string PDF content as a string
     */
    public function generatePdf(Report $report): string
    {
        // Load all relationships including nested ones
        // This prevents lazy-loading issues in DomPDF
        $report->load(
            'user',
            'section1.legalForm',
            'section1.country',
            'section1.sector',
            'section2',
            'section3',
            'section4',
            'section5',
            'section6',
            'section7',
            'frameworks',
            'certifications'
        );

        // Generate PDF using Blade template
        $pdf = Pdf::loadView('reports.pdf', [
            'report' => $report,
        ]);

        // Configure PDF options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('isPhpEnabled', true);

        return $pdf->output();
    }

    /**
     * Generate a filename for the report PDF
     *
     * @param Report $report
     * @return string
     */
    public function getFileName(Report $report): string
    {
        $reportName = Str::slug($report->name ?? 'report');
        $period = Str::slug($report->reporting_period ?? 'document');

        return "{$reportName}_{$period}.pdf";
    }
}
