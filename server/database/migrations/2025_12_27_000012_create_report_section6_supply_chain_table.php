<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_section6_supply_chain', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->unique()->constrained('reports')->onDelete('cascade');
            
            // Supplier Code of Conduct
            $table->boolean('supplier_code_exists')->nullable();
            $table->decimal('suppliers_acknowledged_code_percentage', 5, 2)->nullable();
            
            // Procurement Training
            $table->decimal('procurement_staff_trained_percentage', 5, 2)->nullable();
            
            // Third-Party Risk Management
            $table->boolean('third_party_risk_management_exists')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_section6_supply_chain');
    }
};
