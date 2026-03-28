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
        Schema::create('report_section7_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->unique()->constrained('reports')->onDelete('cascade');
            
            // Net-Zero Target
            $table->integer('netzero_scope1_scope2_target_year')->nullable();
            
            // Science-Based Targets
            $table->boolean('science_based_targets_submitted')->nullable();
            $table->boolean('science_based_targets_validated')->nullable();
            
            // CDP Disclosure
            $table->foreignId('cdp_level_id')->nullable()->constrained('cdp_levels')->onDelete('set null');
            
            // EcoVadis Rating
            $table->foreignId('ecoVadis_rating_id')->nullable()->constrained('ecoVadis_ratings')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_section7_targets');
    }
};
