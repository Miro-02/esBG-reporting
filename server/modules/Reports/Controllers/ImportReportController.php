<?php

namespace Modules\Reports\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Reports\Requests\ImportReportRequest;
use Modules\Reports\Services\ImportReportService;
use Modules\Reports\Data\ImportResult;

class ImportReportController extends Controller
{
    public function __construct(
        private ImportReportService $importService
    ) {}

    /**
     * Import reports from uploaded Excel file
     * 
     * @param ImportReportRequest $request
     * @return JsonResponse
     */
    public function store(ImportReportRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $userId = $request->user()->id;

        // Perform import
        $result = $this->importService->importFromUpload($file, $userId);

        // Determine HTTP status code based on result
        $statusCode = match (true) {
            $result->isCompleteSuccess() => 201,      // Created
            $result->isPartialSuccess() => 207,       // Multi-Status
            default => 400,                           // Bad Request
        };

        return response()->json(
            $result->toArray(),
            $statusCode
        );
    }
}
