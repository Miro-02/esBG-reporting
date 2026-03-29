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
        Schema::table('country_standards', function (Blueprint $table) {
            // Add missing cybersecurity fields
            if (!Schema::hasColumn('country_standards', 'cybersecurity_framework_exists')) {
                $table->boolean('cybersecurity_framework_exists')->nullable()->after('esg_awareness_training_rate')->comment('Cybersecurity framework required');
            }
            
            if (!Schema::hasColumn('country_standards', 'cybersecurity_training_rate')) {
                $table->decimal('cybersecurity_training_rate', 5, 2)->nullable()->after('cybersecurity_framework_exists')->comment('Required minimum cybersecurity training %');
            }
            
            if (!Schema::hasColumn('country_standards', 'data_breach_incidents')) {
                $table->integer('data_breach_incidents')->nullable()->after('cybersecurity_training_rate')->comment('Max allowed data breach incidents');
            }
            
            if (!Schema::hasColumn('country_standards', 'gdpr_compliant')) {
                $table->boolean('gdpr_compliant')->nullable()->after('data_breach_incidents')->comment('GDPR compliance required');
            }
            
            if (!Schema::hasColumn('country_standards', 'security_audit_frequency')) {
                $table->string('security_audit_frequency')->nullable()->after('gdpr_compliant')->comment('Required security audit frequency (e.g., Quarterly, Biannually)');
            }
            
            if (!Schema::hasColumn('country_standards', 'incident_response_plan_exists')) {
                $table->boolean('incident_response_plan_exists')->nullable()->after('security_audit_frequency')->comment('Incident response plan required');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('country_standards', function (Blueprint $table) {
            $table->dropColumn([
                'cybersecurity_framework_exists',
                'cybersecurity_training_rate',
                'data_breach_incidents',
                'gdpr_compliant',
                'security_audit_frequency',
                'incident_response_plan_exists',
            ]);
        });
    }
};
