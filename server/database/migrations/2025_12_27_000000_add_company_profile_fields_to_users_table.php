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
        Schema::table('users', function (Blueprint $table) {
            // Company Profile Fields
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
            $table->foreignId('parent_company_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_subsidiary')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['legal_form_id']);
            $table->dropForeign(['country_id']);
            $table->dropForeign(['sector_id']);
            $table->dropForeign(['parent_company_id']);
            
            // Then drop columns
            $table->dropColumn([
                'company_name',
                'legal_form_id',
                'country_id',
                'sector_id',
                'annual_revenue',
                'number_of_employees',
                'number_of_locations',
                'reporting_period',
                'parent_company_id',
                'is_subsidiary',
            ]);
        });
    }
};
