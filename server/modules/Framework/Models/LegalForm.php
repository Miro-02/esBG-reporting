<?php

namespace Modules\Framework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalForm extends Model
{
    use HasFactory;

    protected $table = 'legal_forms';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Get all users with this legal form.
     */
    public function users()
    {
        return $this->hasMany(\Modules\User\Models\User::class);
    }

    /**
     * Get all report section 1 records with this legal form.
     */
    public function reportSection1CompanyProfiles()
    {
        return $this->hasMany(\Modules\Reports\Models\ReportSection1CompanyProfile::class);
    }
}
