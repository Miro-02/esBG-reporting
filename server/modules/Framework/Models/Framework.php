<?php

namespace Modules\Framework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Framework extends Model
{
    use HasFactory;

    protected $table = 'frameworks';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /**
     * Get all reports that use this framework.
     */
    public function reports()
    {
        return $this->belongsToMany(\Modules\Reports\Models\Report::class, 'report_frameworks');
    }
}
