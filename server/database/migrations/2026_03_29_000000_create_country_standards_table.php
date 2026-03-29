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
        Schema::create('country_standards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');

            // Section 2: Governance Standards
            $table->decimal('female_board_percentage', 5, 2)->nullable()->comment('Required minimum female board %');
            $table->boolean('code_of_conduct_exists')->nullable()->comment('Code of conduct required');
            $table->boolean('esg_committee_exists')->nullable()->comment('ESG committee required');
            $table->boolean('whistleblower_channel_exists')->nullable()->comment('Whistleblower channel required');
            $table->decimal('anti_corruption_training_rate', 5, 2)->nullable()->comment('Required minimum anti-corruption training %');
            $table->decimal('esg_awareness_training_rate', 5, 2)->nullable()->comment('Required minimum ESG training %');

            // Section 3: Environment Standards
            $table->decimal('renewable_energy_percentage', 5, 2)->nullable()->comment('Required minimum renewable energy %');
            $table->decimal('grid_electricity_percentage', 5, 2)->nullable()->comment('Max allowed grid electricity %');
            $table->decimal('total_energy_consumed', 10, 2)->nullable()->comment('Max allowed total energy consumption');
            $table->decimal('ghg_intensity_value', 10, 2)->nullable()->comment('Max allowed GHG intensity');

            // Section 4: Social Standards
            $table->decimal('female_percentage', 5, 2)->nullable()->comment('Required minimum female workforce %');
            $table->decimal('female_leadership_percentage', 5, 2)->nullable()->comment('Required minimum female leadership %');
            $table->decimal('employees_under_30_percentage', 5, 2)->nullable()->comment('Minimum age diversity for under 30');
            $table->decimal('employees_in_training_percentage', 5, 2)->nullable()->comment('Required minimum employee training %');
            $table->decimal('sickness_rate', 5, 2)->nullable()->comment('Maximum allowed sickness rate %');
            $table->boolean('employee_assistance_program_exists')->nullable()->comment('Employee assistance program required');
            $table->decimal('survey_participation_rate', 5, 2)->nullable()->comment('Required minimum survey participation %');

            // Section 5: Cybersecurity Standards
            $table->boolean('cybersecurity_framework_exists')->nullable()->comment('Cybersecurity framework required');
            $table->decimal('cybersecurity_training_rate', 5, 2)->nullable()->comment('Required minimum cybersecurity training %');
            $table->integer('data_breach_incidents')->nullable()->comment('Max allowed data breach incidents');
            $table->boolean('gdpr_compliant')->nullable()->comment('GDPR compliance required');
            $table->boolean('iso27001_certified')->nullable()->comment('ISO 27001 certification required');
            $table->string('security_audit_frequency')->nullable()->comment('Required security audit frequency (e.g., Quarterly, Biannually)');
            $table->boolean('incident_response_plan_exists')->nullable()->comment('Incident response plan required');
            $table->decimal('cybersecurity_training_completion_rate', 5, 2)->nullable()->comment('Required minimum cybersecurity training %');
            $table->integer('number_of_breaches')->nullable()->comment('Max allowed number of breaches');
            $table->integer('customers_affected_by_breaches')->nullable()->comment('Max allowed customers affected by breaches');

            // Section 6: Supply Chain Standards
            $table->boolean('supplier_code_exists')->nullable()->comment('Supplier code of conduct required');
            $table->decimal('suppliers_acknowledged_code_percentage', 5, 2)->nullable()->comment('Required minimum supplier code acknowledgment %');
            $table->decimal('procurement_staff_trained_percentage', 5, 2)->nullable()->comment('Required minimum procurement staff training %');
            $table->boolean('third_party_risk_management_exists')->nullable()->comment('Third-party risk management required');

            // Section 7: Targets Standards
            $table->integer('netzero_target_year')->nullable()->comment('Net-zero target year requirement');

            $table->timestamps();
            $table->index('country_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_standards');
    }
};
