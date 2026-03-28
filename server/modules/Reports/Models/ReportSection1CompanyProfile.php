<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSection1CompanyProfile extends Model
{
    use HasFactory;

    protected $table = 'report_section1_company_profiles';

    protected $fillable = [
        'report_id',
        'company_name',
        'legal_form_id',
        'country_id',
        'sector_id',
        'annual_revenue',
        'number_of_employees',
        'number_of_locations',
        'reporting_period',
        'parent_company_id',
        'is_subsidiary',
    ];

    protected function casts(): array
    {
        return [
            'is_subsidiary' => 'boolean',
            'annual_revenue' => 'decimal:2',
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
     * Get the legal form.
     */
    public function legalForm()
    {
        return $this->belongsTo(\Modules\Framework\Models\LegalForm::class);
    }

    /**
     * Get the country.
     */
    public function country()
    {
        return $this->belongsTo(\Modules\Country\Models\Country::class);
    }

    /**
     * Get the sector.
     */
    public function sector()
    {
        return $this->belongsTo(\Modules\Sector\Models\Sector::class);
    }

    /**
     * Get the parent company if this is a subsidiary.
     */
    public function parentCompany()
    {
        return $this->belongsTo(ReportSection1CompanyProfile::class, 'parent_company_id');
    }

    /**
     * Get all subsidiary companies.
     */
    public function subsidiaries()
    {
        return $this->hasMany(ReportSection1CompanyProfile::class, 'parent_company_id');
    }
}
