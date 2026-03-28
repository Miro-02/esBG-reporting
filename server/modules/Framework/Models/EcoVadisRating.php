<?php

namespace Modules\Framework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EcoVadisRating extends Model
{
    use HasFactory;

    protected $table = 'ecoVadis_ratings';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Get all section 7 reports that have this EcoVadis rating.
     */
    public function reportSection7Targets()
    {
        return $this->hasMany(\Modules\Reports\Models\ReportSection7Targets::class);
    }
}
