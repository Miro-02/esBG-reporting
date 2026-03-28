<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSection4Social extends Model
{
    use HasFactory;

    protected $table = 'report_section4_social';

    protected $fillable = [
        'report_id',
        'total_employees',
        'male_percentage',
        'female_percentage',
        'other_percentage',
        'female_leadership_percentage',
        'employees_under_30_percentage',
        'employees_30_to_50_percentage',
        'employees_over_50_percentage',
        'survey_participation_rate',
        'respect_satisfaction',
        'flexibility_satisfaction',
        'work_life_balance_satisfaction',
        'sickness_rate',
        'lost_time_incident_rate',
        'occupational_fatalities',
        'employees_in_training_percentage',
        'average_training_spend_per_fte',
        'employee_assistance_program_exists',
        'volunteer_days_per_employee',
        'total_volunteer_days',
        'employees_covered_by_collective_bargaining',
    ];

    protected function casts(): array
    {
        return [
            'male_percentage' => 'decimal:2',
            'female_percentage' => 'decimal:2',
            'other_percentage' => 'decimal:2',
            'female_leadership_percentage' => 'decimal:2',
            'employees_under_30_percentage' => 'decimal:2',
            'employees_30_to_50_percentage' => 'decimal:2',
            'employees_over_50_percentage' => 'decimal:2',
            'survey_participation_rate' => 'decimal:2',
            'respect_satisfaction' => 'decimal:2',
            'flexibility_satisfaction' => 'decimal:2',
            'work_life_balance_satisfaction' => 'decimal:2',
            'sickness_rate' => 'decimal:2',
            'lost_time_incident_rate' => 'decimal:4',
            'employees_in_training_percentage' => 'decimal:2',
            'average_training_spend_per_fte' => 'decimal:2',
            'employee_assistance_program_exists' => 'boolean',
            'volunteer_days_per_employee' => 'decimal:2',
            'employees_covered_by_collective_bargaining' => 'decimal:2',
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
