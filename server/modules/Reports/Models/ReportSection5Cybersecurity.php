<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSection5Cybersecurity extends Model
{
    use HasFactory;

    protected $table = 'report_section5_cybersecurity';

    protected $fillable = [
        'report_id',
        'number_of_breaches',
        'customers_affected_by_breaches',
        'law_enforcement_requests',
        'iso27001_certified',
        'cybersecurity_training_completion_rate',
    ];

    protected function casts(): array
    {
        return [
            'iso27001_certified' => 'boolean',
            'cybersecurity_training_completion_rate' => 'decimal:2',
        ];
    }

    /**
     * Get the report this section belongs to.
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
