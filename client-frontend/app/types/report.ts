/**
 * Report Module Types
 * Mirrors backend validation rules and API contracts
 */

// ============================================================================
// Metadata Types
// ============================================================================

export interface ReportMetadata {
  name: string
  description?: string | null
  start_date: string // ISO date format YYYY-MM-DD
  end_date: string // ISO date format YYYY-MM-DD
}

// ============================================================================
// Section 1: Company Profile
// ============================================================================

export interface ReportSection1 {
  company_name?: string | null
  legal_form_id?: number | null
  country_id?: number | null
  sector_id?: number | null
  annual_revenue?: number | null
  number_of_employees?: number | null
  number_of_locations?: number | null
  parent_company_id?: number | null
  is_subsidiary?: boolean | null
}

// ============================================================================
// Section 2: Governance
// ============================================================================

export interface ReportSection2 {
  total_board_members?: number | null
  female_board_percentage?: number | null
  esg_committee_exists?: boolean | null
  esg_committee_frequency?: string | null
  esg_executive_role?: string | null
  code_of_conduct_exists?: boolean | null
  whistleblower_channel_exists?: boolean | null
  whistleblower_reports_filed?: number | null
  anti_corruption_training_rate?: number | null
  esg_awareness_training_rate?: number | null
}

// ============================================================================
// Section 3: Environment
// ============================================================================

export interface ReportSection3 {
  ghg_scope1_emissions?: number | null
  ghg_scope2_emissions?: number | null
  ghg_scope3_emissions?: number | null
  renewable_energy_percentage?: number | null
  waste_reduction_rate?: number | null
  water_consumption?: number | null
  environmental_certification_exists?: boolean | null
}

// ============================================================================
// Section 4: Social
// ============================================================================

export interface ReportSection4 {
  gender_pay_gap_percentage?: number | null
  female_employees_percentage?: number | null
  female_management_percentage?: number | null
  health_safety_incidents?: number | null
  employee_turnover_rate?: number | null
  employee_satisfaction_score?: number | null
  diversity_policy_exists?: boolean | null
}

// ============================================================================
// Section 5: Cybersecurity
// ============================================================================

export interface ReportSection5 {
  cybersecurity_framework_exists?: boolean | null
  cybersecurity_training_rate?: number | null
  data_breach_incidents?: number | null
  gdpr_compliant?: boolean | null
  iso27001_certified?: boolean | null
  security_audit_frequency?: string | null
  incident_response_plan_exists?: boolean | null
}

// ============================================================================
// Section 6: Supply Chain
// ============================================================================

export interface ReportSection6 {
  supplier_code_of_conduct_exists?: boolean | null
  supplier_audit_rate?: number | null
  ethical_sourcing_percentage?: number | null
  conflict_minerals_assessment_exists?: boolean | null
  supply_chain_risk_assessment_exists?: boolean | null
  supplier_diversity_percentage?: number | null
}

// ============================================================================
// Section 7: Targets
// ============================================================================

export interface ReportSection7 {
  emission_reduction_target?: number | null
  emission_reduction_target_year?: number | null
  renewable_energy_target?: number | null
  renewable_energy_target_year?: number | null
  diversity_target_female_management?: number | null
  diversity_target_year?: number | null
  other_targets?: string | null
}

// ============================================================================
// Frameworks & Certifications
// ============================================================================

export interface ReportFrameworksCertifications {
  frameworks: number[]
  certifications: number[]
}

// ============================================================================
// Complete Form Data
// ============================================================================

export interface ReportFormData {
  // Report metadata (filled in step 1)
  metadata: ReportMetadata
  
  // Sections (filled in steps 2-8)
  section1: ReportSection1
  section2: ReportSection2
  section3: ReportSection3
  section4: ReportSection4
  section5: ReportSection5
  section6: ReportSection6
  section7: ReportSection7
  
  // Frameworks and certifications (filled in step 9)
  frameworks_certifications: ReportFrameworksCertifications
}

// ============================================================================
// Step Configuration
// ============================================================================

export interface StepConfig {
  id: number
  title: string
  description: string
  fields: string[] // field names for this step
}

export const STEP_CONFIGS: Record<number, StepConfig> = {
  1: {
    id: 1,
    title: 'Personal Information',
    description: 'Report metadata and basic information',
    fields: ['name', 'description', 'start_date', 'end_date'],
  },
  2: {
    id: 2,
    title: 'Company Profile',
    description: 'Information about your company',
    fields: [
      'company_name',
      'legal_form_id',
      'country_id',
      'sector_id',
      'annual_revenue',
      'number_of_employees',
      'number_of_locations',
      'parent_company_id',
      'is_subsidiary',
    ],
  },
  3: {
    id: 3,
    title: 'Governance',
    description: 'Board composition and governance structure',
    fields: [
      'total_board_members',
      'female_board_percentage',
      'esg_committee_exists',
      'esg_committee_frequency',
      'esg_executive_role',
      'code_of_conduct_exists',
      'whistleblower_channel_exists',
      'whistleblower_reports_filed',
      'anti_corruption_training_rate',
      'esg_awareness_training_rate',
    ],
  },
  4: {
    id: 4,
    title: 'Environment',
    description: 'Environmental impact and emissions',
    fields: [
      'ghg_scope1_emissions',
      'ghg_scope2_emissions',
      'ghg_scope3_emissions',
      'renewable_energy_percentage',
      'waste_reduction_rate',
      'water_consumption',
      'environmental_certification_exists',
    ],
  },
  5: {
    id: 5,
    title: 'Social',
    description: 'Employee and social responsibility data',
    fields: [
      'gender_pay_gap_percentage',
      'female_employees_percentage',
      'female_management_percentage',
      'health_safety_incidents',
      'employee_turnover_rate',
      'employee_satisfaction_score',
      'diversity_policy_exists',
    ],
  },
  6: {
    id: 6,
    title: 'Cybersecurity',
    description: 'Data security and cybersecurity measures',
    fields: [
      'cybersecurity_framework_exists',
      'cybersecurity_training_rate',
      'data_breach_incidents',
      'gdpr_compliant',
      'iso27001_certified',
      'security_audit_frequency',
      'incident_response_plan_exists',
    ],
  },
  7: {
    id: 7,
    title: 'Supply Chain',
    description: 'Supply chain management and ethics',
    fields: [
      'supplier_code_of_conduct_exists',
      'supplier_audit_rate',
      'ethical_sourcing_percentage',
      'conflict_minerals_assessment_exists',
      'supply_chain_risk_assessment_exists',
      'supplier_diversity_percentage',
    ],
  },
  8: {
    id: 8,
    title: 'Targets',
    description: 'ESG targets and goals',
    fields: [
      'emission_reduction_target',
      'emission_reduction_target_year',
      'renewable_energy_target',
      'renewable_energy_target_year',
      'diversity_target_female_management',
      'diversity_target_year',
      'other_targets',
    ],
  },
  9: {
    id: 9,
    title: 'Frameworks & Certifications',
    description: 'Select relevant frameworks and certifications',
    fields: ['frameworks', 'certifications'],
  },
}

// ============================================================================
// API Response Types
// ============================================================================

export interface ApiReportResponse {
  id: number
  user_id: number
  name: string
  description?: string
  start_date: string
  end_date: string
  created_at: string
  updated_at: string
}

export interface ApiErrorResponse {
  message: string
  errors?: Record<string, string[]>
}

// ============================================================================
// Form State Types
// ============================================================================

export interface FormValidationError {
  field: string
  message: string
}

export interface StepSaveState {
  isLoading: boolean
  error: string | null
  success: boolean
}

export interface SaveStates {
  [key: number]: StepSaveState
}
