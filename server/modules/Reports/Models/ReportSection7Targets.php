<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSection7Targets extends Model
{
    use HasFactory;

    protected $table = 'report_section7_targets';

    protected $fillable = [
        'report_id',
        'netzero_scope1_scope2_target_year',
        'science_based_targets_submitted',
        'science_based_targets_validated',
        'cdp_level_id',
        'ecoVadis_rating_id',
    ];

    protected function casts(): array
    {
        return [
            'science_based_targets_submitted' => 'boolean',
            'science_based_targets_validated' => 'boolean',
        ];
    }

    /**
     * Get the report this section belongs to.
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Get the CDP level.
     */
    public function cdpLevel()
    {
        return $this->belongsTo(\Modules\Framework\Models\CdpLevel::class);
    }

    /**
     * Get the EcoVadis rating.
     */
    public function ecoVadisRating()
    {
        return $this->belongsTo(\Modules\Framework\Models\EcoVadisRating::class);
    }
}
