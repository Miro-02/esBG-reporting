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
        Schema::create('report_section1_company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->unique()->constrained('reports')->onDelete('cascade');
            
            // Company Profile
            $table->string('company_name')->nullable();
            $table->foreignId('legal_form_id')->nullable()->constrained('legal_forms')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('sector_id')->nullable()->constrained('sectors')->onDelete('set null');
            
            // Company Statistics
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->integer('number_of_employees')->nullable();
            $table->integer('number_of_locations')->nullable();
            
            // Reporting Period
            $table->string('reporting_period')->nullable();
            
            // Parent Company / Subsidiaries
            $table->foreignId('parent_company_id')->nullable()->constrained('report_section1_company_profiles')->onDelete('set null');
            $table->boolean('is_subsidiary')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_section1_company_profiles');
    }
};
