<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
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
        // Load all relationships
        $report->load(
            'user',
            'section1',
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
        $reportName = str_slug($report->name ?? 'report');
        $period = str_slug($report->reporting_period ?? 'document');

        return "{$reportName}_{$period}.pdf";
    }
}
