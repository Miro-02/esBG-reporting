<?php

namespace Modules\Framework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certification extends Model
{
    use HasFactory;

    protected $table = 'certifications';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Get all reports that have this certification.
     */
    public function reports()
    {
        return $this->belongsToMany(\Modules\Reports\Models\Report::class, 'report_certifications');
    }
}
