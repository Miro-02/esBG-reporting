<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GenerateReportImportTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:generate-import-template {--output=sample_reports.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a sample Excel template for bulk report import with test data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $outputPath = $this->option('output');

        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Reports');

            // Define headers
            $headers = [
                'name',
                'description',
                'start_date',
                'end_date',
                'section_1_company_name',
                'section_1_annual_revenue',
                'section_1_number_of_employees',
                'section_1_number_of_locations',
                'section_2_board_composition',
                'section_2_female_board_percentage',
                'section_2_code_of_conduct_exists',
                'section_3_environmental_policy',
                'section_3_ghg_emissions_scope1',
                'section_3_ghg_emissions_scope2',
                'section_3_renewable_energy_usage',
                'section_4_diversity_and_inclusion_policy',
                'section_4_gender_diversity',
                'section_4_employee_training_hours',
                'section_5_cybersecurity_policy',
                'section_5_cybersecurity_framework_exists',
                'section_5_gdpr_compliant',
                'section_6_supplier_code_of_conduct',
                'section_6_number_of_suppliers',
                'section_7_ghg_emission_reduction_target',
                'section_7_renewable_energy_target',
                'frameworks',
                'certifications',
            ];

            // Write headers
            foreach ($headers as $col => $header) {
                $cell = $sheet->getCellByColumnAndRow($col + 1, 1);
                $cell->setValue($header);
                
                // Style header
                $style = $cell->getStyle();
                $style->getFont()->setBold(true);
                $style->getFont()->getColor()->setRGB('FFFFFF');
                $style->getFill()->setFillType('solid');
                $style->getFill()->getStartColor()->setRGB('2C5F8D'); // Primary color from PDF
            }

            // Add test data - Row 1
            $row1Data = [
                'Q1 2026 Sustainability Report',
                'First quarter ESG performance and sustainability metrics for 2026',
                '2026-01-01',
                '2026-03-31',
                'TechCorp Industries',
                '150000000',
                '2500',
                '8',
                'Board includes representatives from all operating divisions',
                '45',
                'TRUE',
                'Comprehensive environmental management system in place',
                '5000',
                '3200',
                '35',
                'Commitment to equal opportunity and diverse workforce',
                '42',
                '45',
                'ISO 27001 certified data protection measures in place',
                'TRUE',
                'TRUE',
                'Comprehensive code of conduct for all suppliers',
                '350',
                '40% reduction by 2030',
                '50',
                'ISO 9001, ISO 14001',
                'B Corp Certification',
            ];

            foreach ($row1Data as $col => $value) {
                $sheet->getCellByColumnAndRow($col + 1, 2)->setValue($value);
            }

            // Add test data - Row 2
            $row2Data = [
                'H1 2026 Environmental Initiative',
                'Six month progress on environmental targets and climate commitments',
                '2026-01-01',
                '2026-06-30',
                'GreenEnergy Solutions Ltd',
                '85000000',
                '1200',
                '5',
                'Independent board with 50% external directors',
                '52',
                'TRUE',
                'Net-zero pathway established with science-based targets',
                '2100',
                '1800',
                '68',
                'Women in leadership development program established',
                '48',
                '38',
                'Advanced cybersecurity framework with annual audits',
                'TRUE',
                'TRUE',
                'Supplier sustainability program with quarterly reviews',
                '220',
                '50% emissions reduction by 2030',
                '70',
                'GRI Standards, SASB',
                'LEED Certification, ISO 45001',
            ];

            foreach ($row2Data as $col => $value) {
                $sheet->getCellByColumnAndRow($col + 1, 3)->setValue($value);
            }

            // Add test data - Row 3 (with some empty fields to test validation)
            $row3Data = [
                'Annual ESG Summary 2025',
                'Comprehensive annual ESG assessment and reporting',
                '2025-01-01',
                '2025-12-31',
                'Manufacturing Co. Europe',
                '200000000',
                '4500',
                '12',
                'Mixed board composition with external advisors',
                '38',
                'TRUE',
                'Environmental compliance program',
                '8900',
                '6200',
                '28',
                'Diversity hiring and retention initiatives',
                '35',
                '52',
                'Information security program',
                'TRUE',
                'TRUE',
                'Supplier code of conduct',
                '580',
                '30% reduction by 2028',
                '40',
                'ISO 9001',
                '',
            ];

            foreach ($row3Data as $col => $value) {
                $sheet->getCellByColumnAndRow($col + 1, 4)->setValue($value);
            }

            // Auto-size columns - set reasonable width
            foreach (range('A', 'Z') as $col) {
                try {
                    $sheet->getColumnDimension($col)->setWidth(20);
                } catch (\Exception $e) {
                    // Skip if column doesn't exist
                }
            }

            // Freeze header row
            $sheet->freezePane('A2');

            // Write to file
            $writer = new Xlsx($spreadsheet);
            $writer->save($outputPath);

            $this->info("✓ Sample Excel template generated successfully!");
            $this->info("File: <fg=green>{$outputPath}</>");
            $this->line('');
            $this->info('Sample data includes:');
            $this->line('  • Row 1: TechCorp Industries (Q1 2026)');
            $this->line('  • Row 2: GreenEnergy Solutions Ltd (H1 2026)');
            $this->line('  • Row 3: Manufacturing Co. Europe (2025)');
            $this->line('');
            $this->info('Column structure:');
            $this->line('  • Report metadata: name, description, start_date, end_date');
            $this->line('  • Section data: section_[1-7]_[field_name]');
            $this->line('  • Relationships: frameworks, certifications (comma-separated)');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error generating template: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
