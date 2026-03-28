<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $report->name }} - ESG Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            font-size: 11pt;
        }

        .page-break {
            page-break-after: always;
        }

        /* Cover Page */
        .cover {
            page-break-after: always;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-bottom: 3px solid #003366;
        }

        .cover h1 {
            font-size: 36pt;
            color: #003366;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .cover .company-name {
            font-size: 20pt;
            color: #555;
            margin-bottom: 10px;
        }

        .cover .reporting-period {
            font-size: 14pt;
            color: #888;
            margin-bottom: 30px;
        }

        .cover .generated-date {
            font-size: 11pt;
            color: #999;
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        /* Sections */
        .section {
            page-break-after: always;
            margin-bottom: 20px;
        }

        .section:last-child {
            page-break-after: avoid;
        }

        h2 {
            font-size: 18pt;
            color: #003366;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #003366;
            page-break-after: avoid;
        }

        h3 {
            font-size: 13pt;
            color: #333;
            margin: 20px 0 10px 0;
            font-weight: bold;
            page-break-after: avoid;
        }

        p {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            page-break-inside: avoid;
        }

        table th {
            background-color: #e8f1f8;
            color: #003366;
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
            font-weight: bold;
        }

        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Field Display */
        .field {
            margin-bottom: 15px;
        }

        .field-label {
            font-weight: bold;
            color: #003366;
            font-size: 10pt;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .field-value {
            color: #555;
            margin-left: 10px;
            padding: 5px;
            background-color: #f5f5f5;
        }

        .empty-field {
            color: #999;
            font-style: italic;
        }

        /* Lists */
        ul, ol {
            margin-left: 20px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        li {
            margin-bottom: 5px;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: right;
            font-size: 9pt;
            color: #999;
        }

        /* Content wrapper */
        .content {
            padding: 40px 20px;
        }
    </style>
</head>
<body>
    <!-- Cover Page -->
    <div class="cover">
        <h1>ESG Report</h1>
        <div class="company-name">{{ $report->user->company_name ?? 'Company Name' }}</div>
        <div class="reporting-period">
            @if($report->reporting_period)
                Reporting Period: {{ $report->reporting_period }}
            @else
                ESG Report
            @endif
        </div>
        <div class="generated-date">
            Generated on {{ now()->format('F d, Y') }}
        </div>
    </div>

    <div class="content">
        <!-- Section 1: Company Profile -->
        @if($report->section1)
        <div class="section">
            <h2>Section 1: Company Profile</h2>

            <div class="field">
                <div class="field-label">Company Name</div>
                <div class="field-value">{{ $report->section1->company_name ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Legal Form</div>
                <div class="field-value">{{ $report->section1->legalForm->name ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Country</div>
                <div class="field-value">{{ $report->section1->country->name ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Sector</div>
                <div class="field-value">{{ $report->section1->sector->name ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Annual Revenue (€)</div>
                <div class="field-value">{{ $report->section1->annual_revenue ? number_format($report->section1->annual_revenue, 2) : 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Number of Employees</div>
                <div class="field-value">{{ $report->section1->number_of_employees ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Number of Locations</div>
                <div class="field-value">{{ $report->section1->number_of_locations ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Is Subsidiary</div>
                <div class="field-value">{{ $report->section1->is_subsidiary ? 'Yes' : 'No' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Description</div>
                <div class="field-value">{!! nl2br(e($report->section1->description ?? 'N/A')) !!}</div>
            </div>
        </div>
        @endif

        <!-- Section 2: Governance -->
        @if($report->section2)
        <div class="section">
            <h2>Section 2: Governance</h2>

            <div class="field">
                <div class="field-label">Board Composition</div>
                <div class="field-value">{!! nl2br(e($report->section2->board_composition ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Board Independence</div>
                <div class="field-value">{!! nl2br(e($report->section2->board_independence ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Executive Compensation Policy</div>
                <div class="field-value">{!! nl2br(e($report->section2->executive_compensation_policy ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Risk Management Framework</div>
                <div class="field-value">{!! nl2br(e($report->section2->risk_management_framework ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Ethics and Compliance Program</div>
                <div class="field-value">{!! nl2br(e($report->section2->ethics_and_compliance_program ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Stakeholder Engagement</div>
                <div class="field-value">{!! nl2br(e($report->section2->stakeholder_engagement ?? 'N/A')) !!}</div>
            </div>
        </div>
        @endif

        <!-- Section 3: Environment -->
        @if($report->section3)
        <div class="section">
            <h2>Section 3: Environment</h2>

            <div class="field">
                <div class="field-label">Environmental Policy</div>
                <div class="field-value">{!! nl2br(e($report->section3->environmental_policy ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">GHG Emissions (Scope 1, tonnes CO₂e)</div>
                <div class="field-value">{{ $report->section3->ghg_emissions_scope1 ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">GHG Emissions (Scope 2, tonnes CO₂e)</div>
                <div class="field-value">{{ $report->section3->ghg_emissions_scope2 ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">GHG Emissions (Scope 3, tonnes CO₂e)</div>
                <div class="field-value">{{ $report->section3->ghg_emissions_scope3 ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Water Consumption (m³)</div>
                <div class="field-value">{{ $report->section3->water_consumption ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Waste Management</div>
                <div class="field-value">{!! nl2br(e($report->section3->waste_management ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Renewable Energy Usage (%)</div>
                <div class="field-value">{{ $report->section3->renewable_energy_usage ?? 'N/A' }}%</div>
            </div>

            <div class="field">
                <div class="field-label">Climate Risk Assessment</div>
                <div class="field-value">{!! nl2br(e($report->section3->climate_risk_assessment ?? 'N/A')) !!}</div>
            </div>
        </div>
        @endif

        <!-- Section 4: Social -->
        @if($report->section4)
        <div class="section">
            <h2>Section 4: Social</h2>

            <div class="field">
                <div class="field-label">Diversity and Inclusion Policy</div>
                <div class="field-value">{!! nl2br(e($report->section4->diversity_and_inclusion_policy ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Gender Diversity (%)</div>
                <div class="field-value">{{ $report->section4->gender_diversity ?? 'N/A' }}%</div>
            </div>

            <div class="field">
                <div class="field-label">Employee Training Hours</div>
                <div class="field-value">{{ $report->section4->employee_training_hours ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Occupational Health and Safety</div>
                <div class="field-value">{!! nl2br(e($report->section4->occupational_health_and_safety ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Community Engagement Programs</div>
                <div class="field-value">{!! nl2br(e($report->section4->community_engagement_programs ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Human Rights Policy</div>
                <div class="field-value">{!! nl2br(e($report->section4->human_rights_policy ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Employee Turnover Rate (%)</div>
                <div class="field-value">{{ $report->section4->employee_turnover_rate ?? 'N/A' }}%</div>
            </div>
        </div>
        @endif

        <!-- Section 5: Cybersecurity -->
        @if($report->section5)
        <div class="section">
            <h2>Section 5: Cybersecurity</h2>

            <div class="field">
                <div class="field-label">Cybersecurity Policy</div>
                <div class="field-value">{!! nl2br(e($report->section5->cybersecurity_policy ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Data Protection Measures</div>
                <div class="field-value">{!! nl2br(e($report->section5->data_protection_measures ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Security Incidents Reported</div>
                <div class="field-value">{{ $report->section5->security_incidents_reported ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Security Training Completion (%)</div>
                <div class="field-value">{{ $report->section5->security_training_completion ?? 'N/A' }}%</div>
            </div>

            <div class="field">
                <div class="field-label">Data Breach Response Plan</div>
                <div class="field-value">{!! nl2br(e($report->section5->data_breach_response_plan ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Compliance with Standards</div>
                <div class="field-value">{!! nl2br(e($report->section5->compliance_with_standards ?? 'N/A')) !!}</div>
            </div>
        </div>
        @endif

        <!-- Section 6: Supply Chain -->
        @if($report->section6)
        <div class="section">
            <h2>Section 6: Supply Chain</h2>

            <div class="field">
                <div class="field-label">Supplier Code of Conduct</div>
                <div class="field-value">{!! nl2br(e($report->section6->supplier_code_of_conduct ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Number of Suppliers</div>
                <div class="field-value">{{ $report->section6->number_of_suppliers ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Supplier Audits Conducted</div>
                <div class="field-value">{{ $report->section6->supplier_audits_conducted ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Supply Chain Risk Assessment</div>
                <div class="field-value">{!! nl2br(e($report->section6->supply_chain_risk_assessment ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Environmental Supplier Requirements</div>
                <div class="field-value">{!! nl2br(e($report->section6->environmental_supplier_requirements ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Social Compliance Certification</div>
                <div class="field-value">{!! nl2br(e($report->section6->social_compliance_certification ?? 'N/A')) !!}</div>
            </div>
        </div>
        @endif

        <!-- Section 7: Targets -->
        @if($report->section7)
        <div class="section">
            <h2>Section 7: Targets and Goals</h2>

            <div class="field">
                <div class="field-label">GHG Emission Reduction Target</div>
                <div class="field-value">{!! nl2br(e($report->section7->ghg_emission_reduction_target ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Timeline for Targets</div>
                <div class="field-value">{{ $report->section7->timeline_for_targets ?? 'N/A' }}</div>
            </div>

            <div class="field">
                <div class="field-label">Diversity Targets</div>
                <div class="field-value">{!! nl2br(e($report->section7->diversity_targets ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Water Reduction Target</div>
                <div class="field-value">{!! nl2br(e($report->section7->water_reduction_target ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Renewable Energy Target (%)</div>
                <div class="field-value">{{ $report->section7->renewable_energy_target ?? 'N/A' }}%</div>
            </div>

            <div class="field">
                <div class="field-label">Progress Monitoring Method</div>
                <div class="field-value">{!! nl2br(e($report->section7->progress_monitoring_method ?? 'N/A')) !!}</div>
            </div>

            <div class="field">
                <div class="field-label">Accountability Framework</div>
                <div class="field-value">{!! nl2br(e($report->section7->accountability_framework ?? 'N/A')) !!}</div>
            </div>
        </div>
        @endif

        <!-- Frameworks and Certifications -->
        @if($report->frameworks->count() > 0 || $report->certifications->count() > 0)
        <div class="section">
            <h2>Frameworks and Certifications</h2>

            @if($report->frameworks->count() > 0)
            <h3>Frameworks</h3>
            <ul>
                @foreach($report->frameworks as $framework)
                <li>{{ $framework->name }}</li>
                @endforeach
            </ul>
            @endif

            @if($report->certifications->count() > 0)
            <h3>Certifications</h3>
            <ul>
                @foreach($report->certifications as $certification)
                <li>{{ $certification->name }}</li>
                @endforeach
            </ul>
            @endif
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            Generated on {{ now()->format('F d, Y H:i') }}
        </div>
    </div>
</body>
</html>
