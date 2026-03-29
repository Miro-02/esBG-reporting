<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks to allow column changes
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Convert all timestamp columns to datetime
        $tables = [
            'cdp_levels' => ['created_at', 'updated_at'],
            'certifications' => ['created_at', 'updated_at'],
            'countries' => ['created_at', 'updated_at'],
            'country_standards' => ['created_at', 'updated_at'],
            'ecoVadis_ratings' => ['created_at', 'updated_at'],
            'failed_jobs' => ['failed_at'],
            'frameworks' => ['created_at', 'updated_at'],
            'legal_forms' => ['created_at', 'updated_at'],
            'password_reset_tokens' => ['created_at'],
            'reports' => ['created_at', 'updated_at'],
            'report_certifications' => ['created_at', 'updated_at'],
            'report_frameworks' => ['created_at', 'updated_at'],
            'report_section1_company_profiles' => ['created_at', 'updated_at'],
            'report_section2_governance' => ['created_at', 'updated_at'],
            'report_section3_environment' => ['created_at', 'updated_at'],
            'report_section4_social' => ['created_at', 'updated_at'],
            'report_section5_cybersecurity' => ['created_at', 'updated_at'],
            'report_section6_supply_chain' => ['created_at', 'updated_at'],
            'report_section7_targets' => ['created_at', 'updated_at'],
            'sectors' => ['created_at', 'updated_at'],
            'users' => ['email_verified_at', 'created_at', 'updated_at'],
            'personal_access_tokens' => ['created_at', 'updated_at'], // Already done but included for safety
        ];

        foreach ($tables as $table => $columns) {
            foreach ($columns as $column) {
                try {
                    DB::statement("ALTER TABLE `{$table}` MODIFY `{$column}` DATETIME NULL DEFAULT NULL");
                } catch (\Exception $e) {
                    // Silently continue - column might already be datetime or not exist
                }
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a one-way migration - reverting would lose precision
        // and is generally not recommended
    }
};
