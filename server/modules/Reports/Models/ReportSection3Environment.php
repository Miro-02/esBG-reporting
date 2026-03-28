<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSection3Environment extends Model
{
    use HasFactory;

    protected $table = 'report_section3_environment';

    protected $fillable = [
        'report_id',
        'scope1_current_year',
        'scope1_previous_year1',
        'scope1_previous_year2',
        'scope2_market_based',
        'scope2_location_based',
        'scope3_category1',
        'scope3_category4',
        'scope3_category6',
        'scope3_category7',
        'scope3_category11',
        'scope3_other_categories',
        'total_energy_consumed',
        'grid_electricity_percentage',
        'renewable_energy_percentage',
        'netzero_target_year',
        'ghg_intensity_metric',
        'ghg_intensity_value',
    ];

    protected function casts(): array
    {
        return [
            'scope1_current_year' => 'decimal:2',
            'scope1_previous_year1' => 'decimal:2',
            'scope1_previous_year2' => 'decimal:2',
            'scope2_market_based' => 'decimal:2',
            'scope2_location_based' => 'decimal:2',
            'scope3_category1' => 'decimal:2',
            'scope3_category4' => 'decimal:2',
            'scope3_category6' => 'decimal:2',
            'scope3_category7' => 'decimal:2',
            'scope3_category11' => 'decimal:2',
            'scope3_other_categories' => 'json',
            'total_energy_consumed' => 'decimal:2',
            'grid_electricity_percentage' => 'decimal:2',
            'renewable_energy_percentage' => 'decimal:2',
            'ghg_intensity_value' => 'decimal:2',
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
