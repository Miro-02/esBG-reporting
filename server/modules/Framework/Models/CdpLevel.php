<?php

namespace Modules\Framework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CdpLevel extends Model
{
    use HasFactory;

    protected $table = 'cdp_levels';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Get all section 7 reports that have this CDP level.
     */
    public function reportSection7Targets()
    {
        return $this->hasMany(\Modules\Reports\Models\ReportSection7Targets::class);
    }
}
