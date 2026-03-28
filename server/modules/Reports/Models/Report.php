<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'name',
        'description',
        'generated_at',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'generated_at' => 'datetime',
        ];
    }

    /**
     * Get the user (company) associated with this report.
     */
    public function user()
    {
        return $this->belongsTo(\Modules\User\Models\User::class);
    }

    /**
     * Get section 1 data.
     */
    public function section1()
    {
        return $this->hasOne(ReportSection1CompanyProfile::class);
    }

    /**
     * Get section 2 data.
     */
    public function section2()
    {
        return $this->hasOne(ReportSection2Governance::class);
    }

    /**
     * Get section 3 data.
     */
    public function section3()
    {
        return $this->hasOne(ReportSection3Environment::class);
    }

    /**
     * Get section 4 data.
     */
    public function section4()
    {
        return $this->hasOne(ReportSection4Social::class);
    }

    /**
     * Get section 5 data.
     */
    public function section5()
    {
        return $this->hasOne(ReportSection5Cybersecurity::class);
    }

    /**
     * Get section 6 data.
     */
    public function section6()
    {
        return $this->hasOne(ReportSection6SupplyChain::class);
    }

    /**
     * Get section 7 data.
     */
    public function section7()
    {
        return $this->hasOne(ReportSection7Targets::class);
    }

    /**
     * Get frameworks selected for this report.
     */
    public function frameworks()
    {
        return $this->belongsToMany(\Modules\Framework\Models\Framework::class, 'report_frameworks');
    }

    /**
     * Get certifications listed for this report.
     */
    public function certifications()
    {
        return $this->belongsToMany(\Modules\Framework\Models\Certification::class, 'report_certifications');
    }
}
