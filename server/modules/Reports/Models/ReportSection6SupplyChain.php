<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportSection6SupplyChain extends Model
{
    use HasFactory;

    protected $table = 'report_section6_supply_chain';

    protected $fillable = [
        'report_id',
        'supplier_code_exists',
        'suppliers_acknowledged_code_percentage',
        'procurement_staff_trained_percentage',
        'third_party_risk_management_exists',
    ];

    protected function casts(): array
    {
        return [
            'supplier_code_exists' => 'boolean',
            'suppliers_acknowledged_code_percentage' => 'decimal:2',
            'procurement_staff_trained_percentage' => 'decimal:2',
            'third_party_risk_management_exists' => 'boolean',
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
