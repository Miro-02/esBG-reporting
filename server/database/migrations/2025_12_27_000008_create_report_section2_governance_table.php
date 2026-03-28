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
        Schema::create('report_section2_governance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->unique()->constrained('reports')->onDelete('cascade');
            
            // Board & ESG Committee
            $table->integer('total_board_members')->nullable();
            $table->decimal('female_board_percentage', 5, 2)->nullable();
            $table->boolean('esg_committee_exists')->nullable();
            $table->string('esg_committee_frequency')->nullable();
            
            // Executive Oversight
            $table->string('esg_executive_role')->nullable();
            
            // Code of Conduct & Whistleblower
            $table->boolean('code_of_conduct_exists')->nullable();
            $table->boolean('whistleblower_channel_exists')->nullable();
            $table->integer('whistleblower_reports_filed')->nullable();
            
            // Training Completion Rates
            $table->decimal('anti_corruption_training_rate', 5, 2)->nullable();
            $table->decimal('esg_awareness_training_rate', 5, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_section2_governance');
    }
};
