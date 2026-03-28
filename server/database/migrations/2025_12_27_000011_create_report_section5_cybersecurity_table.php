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
        Schema::create('report_section5_cybersecurity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->unique()->constrained('reports')->onDelete('cascade');
            
            // Data Breaches
            $table->integer('number_of_breaches')->nullable();
            $table->integer('customers_affected_by_breaches')->nullable();
            
            // Law Enforcement Requests
            $table->integer('law_enforcement_requests')->nullable();
            
            // Certifications
            $table->boolean('iso27001_certified')->nullable();
            
            // Training
            $table->decimal('cybersecurity_training_completion_rate', 5, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_section5_cybersecurity');
    }
};
