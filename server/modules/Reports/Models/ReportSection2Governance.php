<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSection2Governance extends Model
{
    use HasFactory;

    protected $table = 'report_section2_governance';

    protected $fillable = [
        'report_id',
        'total_board_members',
        'female_board_percentage',
        'esg_committee_exists',
        'esg_committee_frequency',
        'esg_executive_role',
        'code_of_conduct_exists',
        'whistleblower_channel_exists',
        'whistleblower_reports_filed',
        'anti_corruption_training_rate',
        'esg_awareness_training_rate',
    ];

    protected function casts(): array
    {
        return [
            'esg_committee_exists' => 'boolean',
            'code_of_conduct_exists' => 'boolean',
            'whistleblower_channel_exists' => 'boolean',
            'female_board_percentage' => 'decimal:2',
            'anti_corruption_training_rate' => 'decimal:2',
            'esg_awareness_training_rate' => 'decimal:2',
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
