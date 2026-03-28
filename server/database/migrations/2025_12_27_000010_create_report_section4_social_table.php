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
        Schema::create('report_section4_social', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->unique()->constrained('reports')->onDelete('cascade');
            
            // Total Employees
            $table->integer('total_employees')->nullable();
            
            // Gender Distribution
            $table->decimal('male_percentage', 5, 2)->nullable();
            $table->decimal('female_percentage', 5, 2)->nullable();
            $table->decimal('other_percentage', 5, 2)->nullable();
            
            // Leadership
            $table->decimal('female_leadership_percentage', 5, 2)->nullable();
            
            // Age Distribution
            $table->decimal('employees_under_30_percentage', 5, 2)->nullable();
            $table->decimal('employees_30_to_50_percentage', 5, 2)->nullable();
            $table->decimal('employees_over_50_percentage', 5, 2)->nullable();
            
            // Employee Engagement
            $table->decimal('survey_participation_rate', 5, 2)->nullable();
            $table->decimal('respect_satisfaction', 5, 2)->nullable();
            $table->decimal('flexibility_satisfaction', 5, 2)->nullable();
            $table->decimal('work_life_balance_satisfaction', 5, 2)->nullable();
            
            // Health & Safety
            $table->decimal('sickness_rate', 5, 2)->nullable();
            $table->decimal('lost_time_incident_rate', 8, 4)->nullable();
            $table->integer('occupational_fatalities')->nullable();
            
            // Training & Development
            $table->decimal('employees_in_training_percentage', 5, 2)->nullable();
            $table->decimal('average_training_spend_per_fte', 15, 2)->nullable();
            
            // Employee Support
            $table->boolean('employee_assistance_program_exists')->nullable();
            $table->decimal('volunteer_days_per_employee', 8, 2)->nullable();
            $table->integer('total_volunteer_days')->nullable();
            
            // Collective Bargaining
            $table->decimal('employees_covered_by_collective_bargaining', 5, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_section4_social');
    }
};
