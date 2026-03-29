<?php

namespace Modules\Reports\Data;

class ImportResult
{
    public int $totalRows;
    public int $successCount = 0;
    public int $failureCount = 0;
    public array $failures = [];
    public array $createdReportIds = [];

    public function __construct(int $totalRows = 0)
    {
        $this->totalRows = $totalRows;
    }

    /**
     * Add a successful report creation
     */
    public function addSuccess(int $reportId): self
    {
        $this->successCount++;
        $this->createdReportIds[] = $reportId;
        return $this;
    }

    /**
     * Add a failed row
     */
    public function addFailure(
        int $rowNumber,
        array $errors,
        ?string $reportName = null
    ): self {
        $this->failureCount++;
        $this->failures[] = [
            'rowNumber' => $rowNumber,
            'reportName' => $reportName,
            'errors' => $errors,
        ];
        return $this;
    }

    /**
     * Convert to array for API response
     */
    public function toArray(): array
    {
        return [
            'totalRows' => $this->totalRows,
            'successCount' => $this->successCount,
            'failureCount' => $this->failureCount,
            'createdReportIds' => $this->createdReportIds,
            'failures' => $this->failures,
        ];
    }

    /**
     * Check if import was completely successful
     */
    public function isCompleteSuccess(): bool
    {
        return $this->failureCount === 0 && $this->successCount > 0;
    }

    /**
     * Check if import had partial success
     */
    public function isPartialSuccess(): bool
    {
        return $this->failureCount > 0 && $this->successCount > 0;
    }

    /**
     * Check if import was complete failure
     */
    public function isCompleteFailure(): bool
    {
        return $this->failureCount > 0 && $this->successCount === 0;
    }
}
