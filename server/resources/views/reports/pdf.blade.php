<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $report->name }} - ESG Report</title>
    <style>
        /* Color Palette */
        :root {
            --primary: #2c5f8d;
            --primary-dark: #1e4d6d;
            --accent-green: #27ae60;
            --accent-amber: #f39c12;
            --accent-red: #e74c3c;
            --accent-gray: #95a5a6;
            --bg-light: #f7f9fb;
            --bg-white: #ffffff;
            --border-subtle: #d0dce3;
            --text-dark: #1a1a1a;
            --text-gray: #555555;
            --text-light: #999999;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
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
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--bg-white) 100%);
            border-bottom: 4px solid var(--primary);
        }

        .cover h1 {
            font-size: 48pt;
            color: var(--primary);
            margin-bottom: 30px;
            font-weight: bold;
            letter-spacing: -0.5pt;
        }

        .cover .company-name {
            font-size: 24pt;
            color: var(--text-gray);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .cover .reporting-period {
            font-size: 16pt;
            color: var(--text-light);
            margin-bottom: 40px;
        }

        .cover .generated-date {
            font-size: 11pt;
            color: var(--text-light);
            margin-top: 60px;
            border-top: 2px solid var(--border-subtle);
            padding-top: 25px;
        }

        /* Table of Contents */
        .toc-page {
            page-break-after: always;
            padding: 50px 40px;
            background: var(--bg-white);
        }

        .toc-page h1 {
            font-size: 28pt;
            color: var(--primary);
            margin-bottom: 40px;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 15px;
        }

        .toc-list {
            list-style: none;
            padding: 0;
        }

        .toc-list li {
            margin-bottom: 12px;
            padding-left: 20px;
            font-size: 12pt;
            color: var(--text-gray);
            line-height: 1.8;
        }

        .toc-list li:before {
            content: "• ";
            color: var(--primary);
            font-weight: bold;
            margin-right: 8px;
            margin-left: -20px;
        }

        /* Executive Summary Page */
        .executive-summary {
            page-break-after: always;
            padding: 50px 40px;
        }

        .executive-summary h1 {
            font-size: 28pt;
            color: var(--primary);
            margin-bottom: 40px;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 15px;
        }

        .executive-summary p {
            color: var(--text-gray);
            margin-bottom: 30px;
            font-size: 11pt;
            line-height: 1.7;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .kpi-card {
            background: var(--bg-white);
            border-left: 5px solid var(--primary);
            padding: 20px;
            page-break-inside: avoid;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .kpi-card.status-success {
            border-left-color: var(--accent-green);
        }

        .kpi-card.status-warning {
            border-left-color: var(--accent-amber);
        }

        .kpi-card.status-critical {
            border-left-color: var(--accent-red);
        }

        .kpi-card.status-neutral {
            border-left-color: var(--accent-gray);
        }

        .kpi-value {
            font-size: 26pt;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .kpi-label {
            font-size: 10pt;
            color: var(--text-light);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5pt;
            margin-bottom: 8px;
        }

        .kpi-status {
            font-size: 9pt;
            color: var(--accent-green);
            font-weight: bold;
            margin-top: 10px;
        }

        .kpi-status.warning {
            color: var(--accent-amber);
        }

        .kpi-status.critical {
            color: var(--accent-red);
        }

        .kpi-status.neutral {
            color: var(--accent-gray);
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 2px;
            font-size: 8pt;
            font-weight: bold;
            margin-left: 5px;
            text-transform: uppercase;
            letter-spacing: 0.3pt;
        }

        .status-badge.success {
            background-color: rgba(39, 174, 96, 0.15);
            color: var(--accent-green);
        }

        .status-badge.warning {
            background-color: rgba(243, 156, 18, 0.15);
            color: var(--accent-amber);
        }

        .status-badge.critical {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--accent-red);
        }

        .status-badge.neutral {
            background-color: rgba(149, 165, 166, 0.15);
            color: var(--accent-gray);
        }

        /* Progress Bar */
        .progress-bar {
            width: 100%;
            height: 18px;
            background: var(--border-subtle);
            border-radius: 2px;
            overflow: hidden;
            margin: 10px 0;
            page-break-inside: avoid;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-red) 0%, var(--accent-amber) 50%, var(--accent-green) 100%);
            transition: width 0.3s ease;
        }

        .progress-label {
            font-size: 9pt;
            color: var(--text-light);
            margin-top: 5px;
            display: flex;
            justify-content: space-between;
        }

        /* Sections */
        .section {
            page-break-after: always;
            margin-bottom: 0;
        }

        .section-cover {
            page-break-after: always;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--bg-white) 100%);
            border-bottom: 3px solid var(--border-subtle);
        }

        .section-cover h2 {
            font-size: 36pt;
            color: var(--primary);
            margin: 0 0 20px 0;
            padding: 0;
            border: none;
        }

        .section-cover-subtitle {
            font-size: 14pt;
            color: var(--text-light);
            margin-top: 20px;
        }

        .section:last-child {
            page-break-after: avoid;
        }

        h2 {
            font-size: 22pt;
            color: var(--primary);
            margin: 40px 0 25px 0;
            padding-bottom: 12px;
            border-bottom: 3px solid var(--primary);
            page-break-after: avoid;
            font-weight: 600;
        }

        h3 {
            font-size: 14pt;
            color: var(--primary-dark);
            margin: 25px 0 15px 0;
            font-weight: 600;
            page-break-after: avoid;
        }

        p {
            margin-bottom: 12px;
            page-break-inside: avoid;
            color: var(--text-gray);
            line-height: 1.7;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            page-break-inside: avoid;
        }

        table th {
            background-color: var(--primary);
            color: var(--bg-white);
            padding: 12px;
            text-align: left;
            border: 1px solid var(--border-subtle);
            font-weight: 600;
            font-size: 10pt;
        }

        table td {
            padding: 12px;
            border: 1px solid var(--border-subtle);
            color: var(--text-gray);
            font-size: 10pt;
        }

        table tr:nth-child(even) {
            background-color: var(--bg-light);
        }

        table tr:hover {
            background-color: rgba(44, 95, 141, 0.05);
        }

        /* Field Display */
        .field {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .field-label {
            font-weight: 600;
            color: var(--primary);
            font-size: 10pt;
            text-transform: uppercase;
            letter-spacing: 0.3pt;
            margin-bottom: 5px;
        }

        .field-value {
            color: var(--text-gray);
            padding: 10px 12px;
            background-color: var(--bg-light);
            border-left: 3px solid var(--primary);
            margin-left: 0;
        }

        .field-value.empty {
            color: var(--text-light);
            font-style: italic;
        }

        /* Lists */
        ul, ol {
            margin-left: 25px;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        li {
            margin-bottom: 8px;
            line-height: 1.6;
            color: var(--text-gray);
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid var(--border-subtle);
            text-align: center;
            font-size: 9pt;
            color: var(--text-light);
        }

        /* Content wrapper */
        .content {
            padding: 50px 40px;
            background: var(--bg-white);
        }

        .section-content {
            padding: 50px 40px;
        }

        /* Frameworks & Certifications */
        .frameworks-section {
            page-break-after: avoid;
        }

        .frameworks-section h3 {
            margin-top: 20px;
            margin-bottom: 12px;
            color: var(--primary);
        }

        .frameworks-section ul {
            margin-left: 20px;
        }

        .frameworks-section li {
            margin-bottom: 6px;
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

    <!-- Table of Contents -->
    @php
        $toc_items = [];
        if($report->section1) $toc_items[] = 'Section 1: Company Profile';
        if($report->section2) $toc_items[] = 'Section 2: Governance';
        if($report->section3) $toc_items[] = 'Section 3: Environment';
        if($report->section4) $toc_items[] = 'Section 4: Social';
        if($report->section5) $toc_items[] = 'Section 5: Cybersecurity';
        if($report->section6) $toc_items[] = 'Section 6: Supply Chain';
        if($report->section7) $toc_items[] = 'Section 7: Targets and Goals';
        if($report->frameworks->count() > 0 || $report->certifications->count() > 0) $toc_items[] = 'Frameworks and Certifications';
    @endphp

    @if(count($toc_items) > 0)
    <div class="toc-page">
        <h1>Contents</h1>
        <ul class="toc-list">
            @foreach($toc_items as $item)
            <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Executive Summary -->
    <div class="executive-summary">
        <h1>Executive Summary</h1>
        <p>Key performance indicators and strategic metrics for the reporting period.</p>
        
        <div class="kpi-grid">
            @if($report->section1 && $report->section1->company_name)
            <div class="kpi-card status-neutral">
                <div class="kpi-label">Company</div>
                <div class="kpi-value">{{ substr($report->section1->company_name, 0, 20) }}</div>
            </div>
            @endif

            @if($report->section1 && $report->section1->number_of_employees)
            <div class="kpi-card status-success">
                <div class="kpi-label">Employees</div>
                <div class="kpi-value">{{ number_format($report->section1->number_of_employees) }}</div>
            </div>
            @endif

            @if($report->section1 && $report->section1->annual_revenue)
            <div class="kpi-card status-success">
                <div class="kpi-label">Annual Revenue</div>
                <div class="kpi-value">€{{ number_format($report->section1->annual_revenue / 1000000, 1) }}M</div>
            </div>
            @endif

            @if($report->section3 && ($report->section3->ghg_emissions_scope1 || $report->section3->ghg_emissions_scope2))
            <div class="kpi-card status-warning">
                <div class="kpi-label">Total GHG Emissions (Scope 1+2)</div>
                <div class="kpi-value">{{ ($report->section3->ghg_emissions_scope1 ?? 0) + ($report->section3->ghg_emissions_scope2 ?? 0) }}</div>
                <div style="font-size: 10pt; color: var(--text-light); margin-top: 5px;">tonnes CO₂e</div>
            </div>
            @endif

            @if($report->section4 && $report->section4->gender_diversity)
            <div class="kpi-card status-success">
                <div class="kpi-label">Gender Diversity</div>
                <div class="kpi-value">{{ $report->section4->gender_diversity }}%</div>
                <div class="kpi-status">Women in workforce</div>
            </div>
            @endif

            @if($report->section3 && $report->section3->renewable_energy_usage)
            <div class="kpi-card @if($report->section3->renewable_energy_usage >= 50) status-success @else status-warning @endif">
                <div class="kpi-label">Renewable Energy</div>
                <div class="kpi-value">{{ $report->section3->renewable_energy_usage }}%</div>
                <div class="kpi-status @if($report->section3->renewable_energy_usage >= 50) success @else warning @endif">
                    @if($report->section3->renewable_energy_usage >= 75)
                        ✓ On Target
                    @elseif($report->section3->renewable_energy_usage >= 50)
                        △ Monitor
                    @else
                        ✗ Below Target
                    @endif
                </div>
            </div>
            @endif
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
                <div class="field-value">{{ $report->section1->annual_revenue ? '€ ' . number_format($report->section1->annual_revenue, 0) : 'N/A' }}</div>
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
                <div class="field-value">
                    {{ $report->section3->renewable_energy_usage ?? 'N/A' }}%
                    <span class="status-badge @if($report->section3->renewable_energy_usage >= 50) success @elseif($report->section3->renewable_energy_usage >= 30) warning @else critical @endif">
                        @if($report->section3->renewable_energy_usage >= 75)
                            ✓ On Target
                        @elseif($report->section3->renewable_energy_usage >= 50)
                            △ Monitor
                        @else
                            ✗ Below Target
                        @endif
                    </span>
                </div>
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
                <div class="field-value">
                    {{ $report->section4->gender_diversity ?? 'N/A' }}%
                    <span class="status-badge @if($report->section4->gender_diversity >= 40) success @elseif($report->section4->gender_diversity >= 30) warning @else critical @endif">
                        @if($report->section4->gender_diversity >= 40)
                            ✓ On Target
                        @elseif($report->section4->gender_diversity >= 30)
                            △ Monitor
                        @else
                            ✗ Below Target
                        @endif
                    </span>
                </div>
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
                <div class="field-value">
                    {{ $report->section5->security_incidents_reported ?? 'N/A' }}
                    <span class="status-badge @if(($report->section5->security_incidents_reported ?? 0) == 0) success @elseif(($report->section5->security_incidents_reported ?? 0) < 3) warning @else critical @endif">
                        @if(($report->section5->security_incidents_reported ?? 0) == 0)
                            ✓ Secure
                        @elseif(($report->section5->security_incidents_reported ?? 0) < 3)
                            △ Monitor
                        @else
                            ✗ Review Needed
                        @endif
                    </span>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Security Training Completion (%)</div>
                <div class="field-value">
                    {{ $report->section5->security_training_completion ?? 'N/A' }}%
                    <span class="status-badge @if($report->section5->security_training_completion >= 85) success @elseif($report->section5->security_training_completion >= 70) warning @else critical @endif">
                        @if($report->section5->security_training_completion >= 85)
                            ✓ Excellent
                        @elseif($report->section5->security_training_completion >= 70)
                            △ Improving
                        @else
                            ✗ Action Needed
                        @endif
                    </span>
                </div>
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
                @if($report->section7->renewable_energy_target && $report->section3->renewable_energy_usage)
                <div style="margin-top: 10px;">
                    <div class="progress-bar">
                        @php
                            $progress = min(100, round(($report->section3->renewable_energy_usage / $report->section7->renewable_energy_target) * 100));
                        @endphp
                        <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                    </div>
                    <div class="progress-label">
                        <span>Progress: {{ $progress }}%</span>
                        <span>Target: {{ $report->section7->renewable_energy_target }}%</span>
                    </div>
                </div>
                @endif
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
        <div class="section frameworks-section">
            <h2>Frameworks and Certifications</h2>

            @if($report->frameworks->count() > 0)
            <h3>Frameworks</h3>
            <ul>
                @foreach($report->frameworks as $framework)
                <li><strong>{{ $framework->name }}</strong></li>
                @endforeach
            </ul>
            @endif

            @if($report->certifications->count() > 0)
            <h3>Certifications</h3>
            <ul>
                @foreach($report->certifications as $certification)
                <li><strong>{{ $certification->name }}</strong></li>
                @endforeach
            </ul>
            @endif
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            ESG Report | Generated on {{ now()->format('F d, Y \a\t H:i') }} | Confidential
        </div>
    </div>
</body>
</html>
