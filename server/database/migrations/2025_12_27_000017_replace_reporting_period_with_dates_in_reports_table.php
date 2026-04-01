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
        Schema::table('reports', function (Blueprint $table) {
            // Drop the old reporting_period column
            $table->dropColumn('reporting_period');
            
            // Add new start_date and end_date columns
            $table->date('start_date')->after('user_id');
            $table->date('end_date')->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn(['start_date', 'end_date']);
            
            // Restore the old reporting_period column
            $table->string('reporting_period')->nullable();
        });
    }
};
