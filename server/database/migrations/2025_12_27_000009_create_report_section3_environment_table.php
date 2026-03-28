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
        Schema::create('report_section3_environment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->unique()->constrained('reports')->onDelete('cascade');
            
            // Scope 1 Emissions (current + 2 previous years)
            $table->decimal('scope1_current_year', 15, 2)->nullable();
            $table->decimal('scope1_previous_year1', 15, 2)->nullable();
            $table->decimal('scope1_previous_year2', 15, 2)->nullable();
            
            // Scope 2 Emissions
            $table->decimal('scope2_market_based', 15, 2)->nullable();
            $table->decimal('scope2_location_based', 15, 2)->nullable();
            
            // Scope 3 Emissions by Category
            $table->decimal('scope3_category1', 15, 2)->nullable();
            $table->decimal('scope3_category4', 15, 2)->nullable();
            $table->decimal('scope3_category6', 15, 2)->nullable();
            $table->decimal('scope3_category7', 15, 2)->nullable();
            $table->decimal('scope3_category11', 15, 2)->nullable();
            $table->json('scope3_other_categories')->nullable();
            
            // Energy
            $table->decimal('total_energy_consumed', 15, 2)->nullable();
            $table->decimal('grid_electricity_percentage', 5, 2)->nullable();
            $table->decimal('renewable_energy_percentage', 5, 2)->nullable();
            
            // Net-Zero & Intensity
            $table->integer('netzero_target_year')->nullable();
            $table->string('ghg_intensity_metric')->nullable();
            $table->decimal('ghg_intensity_value', 15, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_section3_environment');
    }
};
