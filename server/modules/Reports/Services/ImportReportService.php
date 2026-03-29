<?php

namespace Modules\Reports\Services;

use Modules\Reports\Data\ImportResult;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImportReportService
{
    private Worksheet $worksheet;
    private array $headers = [];
    private array $requiredColumns = ['name', 'start_date', 'end_date'];
    private array $optionalColumns = ['description'];

    public function __construct(
        private ReportBatchService $batchService
    ) {}

    /**
     * Parse and import Excel file
     * 
     * @param UploadedFile $file
     * @param int $userId
     * @return ImportResult
     */
    public function importFromUpload(UploadedFile $file, int $userId): ImportResult
    {
        try {
            // Read Excel file
            $spreadsheet = IOFactory::load($file->getPathname());
            $this->worksheet = $spreadsheet->getActiveSheet();

            // Parse headers
            $this->parseHeaders();

            // Validate headers
            $headerValidationErrors = $this->validateHeaders();
            if ($headerValidationErrors) {
                // If header validation fails, return single failure
                $result = new ImportResult(0);
                $result->addFailure(1, $headerValidationErrors);
                return $result;
            }

            // Parse and validate rows
            $validatedRows = $this->parseAndValidateRows();

            // If no valid rows, return empty result
            if (empty($validatedRows['valid'])) {
                $result = new ImportResult(count($validatedRows['all'] ?? []));
                foreach ($validatedRows['invalid'] ?? [] as $rowNumber => $errors) {
                    $result->addFailure($rowNumber, $errors);
                }
                return $result;
            }

            // Create reports from validated rows
            return $this->batchService->createReportsFromValidatedRows(
                $validatedRows['valid'],
                $userId
            );

        } catch (\Exception $e) {
            Log::error('Excel import error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
            ]);

            $result = new ImportResult(0);
            $result->addFailure(1, ["File parsing error: " . $e->getMessage()]);
            return $result;
        }
    }

    /**
     * Parse header row and build column mapping
     */
    private function parseHeaders(): void
    {
        $headerRow = $this->worksheet->getRowIterator(1, 1)->current();
        
        foreach ($headerRow->getCellIterator() as $cell) {
            $value = $cell->getValue();
            if ($value !== null && $value !== '') {
                $this->headers[strtolower(trim($value))] = $cell->getColumn();
            }
        }
    }

    /**
     * Validate that required columns exist
     * 
     * @return array Errors if any
     */
    private function validateHeaders(): array
    {
        $errors = [];

        foreach ($this->requiredColumns as $column) {
            if (!isset($this->headers[$column])) {
                $errors[] = "Required column '{$column}' is missing";
            }
        }

        return $errors;
    }

    /**
     * Parse and validate all data rows
     * 
     * @return array ['valid' => [...], 'invalid' => [...], 'all' => [...]]
     */
    private function parseAndValidateRows(): array
    {
        $validRows = [];
        $invalidRows = [];
        $allRowCount = 0;

        $rows = $this->worksheet->getRowIterator(2); // Start from row 2 (after header)

        foreach ($rows as $row) {
            $rowNumber = $row->getRowIndex();
            $rowData = $this->extractRowData($row);

            // Skip empty rows
            if (empty(array_filter($rowData))) {
                continue;
            }

            $allRowCount++;

            $errors = $this->validateRow($rowData);
            
            if (empty($errors)) {
                $validRows[$rowNumber - 2] = $rowData; // Adjust index for API (0-based)
            } else {
                $invalidRows[$rowNumber] = $errors;
            }
        }

        return [
            'valid' => $validRows,
            'invalid' => $invalidRows,
            'all' => $allRowCount,
        ];
    }

    /**
     * Extract data from a single row based on headers
     */
    private function extractRowData(\PhpOffice\PhpSpreadsheet\Worksheet\Row $row): array
    {
        $data = [];
        $rowIndex = $row->getRowIndex();

        foreach ($this->headers as $columnName => $columnLetter) {
            $cell = $this->worksheet->getCell($columnLetter . $rowIndex);
            $value = $cell->getValue();
            
            // Convert dates if they're in Excel format
            if (in_array($columnName, ['start_date', 'end_date']) && is_numeric($value)) {
                $value = $this->excelDateToString($value);
            }

            $data[$columnName] = $this->normalizeValue($value, $columnName);
        }

        // Collect all columns that start with "section_" for section data
        foreach ($this->worksheet->getColumnIterator() as $column) {
            $columnLetter = $column->getColumnIndex();
            $headerCell = $this->worksheet->getCell($columnLetter . '1')->getValue();
            
            if ($headerCell && strpos(strtolower($headerCell), 'section_') === 0) {
                $columnName = strtolower(trim($headerCell));
                $valueCell = $this->worksheet->getCell($columnLetter . $rowIndex);
                $value = $valueCell->getValue();
                $data[$columnName] = $this->normalizeValue($value, $columnName);
            }
        }

        return $data;
    }

    /**
     * Validate a single row of data
     * 
     * @return array Validation errors
     */
    private function validateRow(array $data): array
    {
        $errors = [];

        // Validate required fields
        if (empty($data['name'] ?? null)) {
            $errors[] = "Report name is required";
        } else if (strlen($data['name']) > 255) {
            $errors[] = "Report name cannot exceed 255 characters";
        }

        // Validate dates
        if (empty($data['start_date'] ?? null)) {
            $errors[] = "Start date is required";
        } else if (!$this->isValidDate($data['start_date'])) {
            $errors[] = "Start date must be a valid date (YYYY-MM-DD)";
        }

        if (empty($data['end_date'] ?? null)) {
            $errors[] = "End date is required";
        } else if (!$this->isValidDate($data['end_date'])) {
            $errors[] = "End date must be a valid date (YYYY-MM-DD)";
        }

        // Validate end_date >= start_date
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $startDate = $this->parseDate($data['start_date']);
            $endDate = $this->parseDate($data['end_date']);
            
            if ($startDate && $endDate && $endDate < $startDate) {
                $errors[] = "End date must be after or equal to start date";
            }
        }

        return $errors;
    }

    /**
     * Check if value is a valid date
     */
    private function isValidDate($date): bool
    {
        if (empty($date)) {
            return false;
        }

        // Handle Excel serial dates (numbers)
        if (is_numeric($date)) {
            return true; // Already converted by excelDateToString
        }

        // Check common date formats
        $formats = ['Y-m-d', 'Y/m/d', 'd-m-Y', 'd/m/Y', 'm-d-Y', 'm/d/Y'];
        
        foreach ($formats as $format) {
            $parsed = \DateTime::createFromFormat($format, (string) $date);
            if ($parsed !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Parse date string to DateTime for comparison
     */
    private function parseDate($date): ?\DateTime
    {
        if (empty($date)) {
            return null;
        }

        $formats = ['Y-m-d', 'Y/m/d', 'd-m-Y', 'd/m/Y', 'm-d-Y', 'm/d/Y'];
        
        foreach ($formats as $format) {
            $parsed = \DateTime::createFromFormat($format, (string) $date);
            if ($parsed !== false) {
                return $parsed;
            }
        }

        return null;
    }

    /**
     * Convert Excel serial date to string
     * Excel stores dates as numbers, e.g., 45000 = Jan 1, 2023
     */
    private function excelDateToString($excelDate): string
    {
        if (is_numeric($excelDate)) {
            try {
                $date = \DateTime::createFromFormat(
                    'Y-m-d',
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d')
                );
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
                Log::warning("Failed to convert Excel date: {$excelDate}");
                return $excelDate;
            }
        }

        return $excelDate;
    }

    /**
     * Normalize value from Excel based on type
     * Converts boolean strings to integers, trims whitespace, etc.
     */
    private function normalizeValue($value, string $columnName): mixed
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Convert boolean values to integers (for database columns that expect tinyint/boolean)
        if (is_bool($value)) {
            return (int) $value;
        }

        if (is_string($value)) {
            $lowerValue = strtolower(trim($value));
            
            // Handle boolean strings from Excel
            if ($lowerValue === 'true' || $lowerValue === 'yes' || $lowerValue === '1') {
                return 1;
            }
            if ($lowerValue === 'false' || $lowerValue === 'no' || $lowerValue === '0') {
                return 0;
            }

            // Convert percentage strings to numbers if column name suggests percentage
            if (strpos($columnName, 'percentage') !== false && preg_match('/^(\d+(?:\.\d+)?)%?$/', trim($value), $matches)) {
                return (float) $matches[1];
            }

            return trim($value);
        }

        return $value;
    }

    /**
     * Get expected columns for documentation
     */
    public function getExpectedColumns(): array
    {
        return [
            'required' => $this->requiredColumns,
            'optional' => array_merge($this->optionalColumns, [
                'frameworks',
                'certifications',
                'section_1_company_name',
                'section_1_annual_revenue',
                'section_1_number_of_employees',
                // ... additional section columns
            ]),
        ];
    }
}
