/**
 * Report Form Validation Composable
 * Provides validation logic for all form steps
 */

import type { ReportFormData, ReportMetadata } from '~/types/report'

export const useReportValidation = () => {
  /**
   * Validate metadata (step 1)
   * Returns array of error messages, empty if valid
   */
  const validateMetadata = (data: Partial<ReportMetadata>): string[] => {
    const errors: string[] = []

    if (!data.name || data.name.trim().length === 0) {
      errors.push('Report name is required')
    }
    else if (data.name.length > 255) {
      errors.push('Report name cannot exceed 255 characters')
    }

    if (data.description && data.description.length > 5000) {
      errors.push('Description cannot exceed 5000 characters')
    }

    if (!data.start_date) {
      errors.push('Start date is required')
    }

    if (!data.end_date) {
      errors.push('End date is required')
    }

    if (data.start_date && data.end_date) {
      const startDate = new Date(data.start_date)
      const endDate = new Date(data.end_date)

      if (isNaN(startDate.getTime())) {
        errors.push('Start date is not a valid date')
      }

      if (isNaN(endDate.getTime())) {
        errors.push('End date is not a valid date')
      }

      if (startDate > endDate) {
        errors.push('End date must be after or equal to start date')
      }
    }

    return errors
  }

  /**
   * Validate numeric field (percentage)
   */
  const validatePercentage = (value: number | undefined, fieldName: string): string[] => {
    const errors: string[] = []

    if (value !== undefined && value !== null) {
      if (typeof value !== 'number') {
        errors.push(`${fieldName} must be a number`)
      }
      else if (value < 0 || value > 100) {
        errors.push(`${fieldName} must be between 0 and 100`)
      }
    }

    return errors
  }

  /**
   * Validate numeric field (non-negative)
   */
  const validateNonNegativeNumber = (
    value: number | undefined,
    fieldName: string,
  ): string[] => {
    const errors: string[] = []

    if (value !== undefined && value !== null) {
      if (typeof value !== 'number') {
        errors.push(`${fieldName} must be a number`)
      }
      else if (value < 0) {
        errors.push(`${fieldName} cannot be negative`)
      }
    }

    return errors
  }

  /**
   * Validate numeric field (integer)
   */
  const validateInteger = (value: number | undefined, fieldName: string): string[] => {
    const errors: string[] = []

    if (value !== undefined && value !== null) {
      if (!Number.isInteger(value)) {
        errors.push(`${fieldName} must be a whole number`)
      }
      else if (value < 0) {
        errors.push(`${fieldName} cannot be negative`)
      }
    }

    return errors
  }

  /**
   * Validate year field
   */
  const validateYear = (value: number | undefined, fieldName: string): string[] => {
    const errors: string[] = []
    const currentYear = new Date().getFullYear()

    if (value !== undefined && value !== null) {
      if (!Number.isInteger(value)) {
        errors.push(`${fieldName} must be a whole number`)
      }
      else if (value < 1900 || value > currentYear + 100) {
        errors.push(`${fieldName} must be a valid year`)
      }
    }

    return errors
  }

  /**
   * Validate section 1 (Company Profile)
   */
  const validateSection1 = (data: any): string[] => {
    const errors: string[] = []

    if (data.company_name && data.company_name.length > 255) {
      errors.push('Company name cannot exceed 255 characters')
    }

    if (data.annual_revenue) {
      errors.push(...validateNonNegativeNumber(data.annual_revenue, 'Annual revenue'))
    }

    if (data.number_of_employees) {
      errors.push(...validateInteger(data.number_of_employees, 'Number of employees'))
    }

    if (data.number_of_locations) {
      errors.push(...validateInteger(data.number_of_locations, 'Number of locations'))
    }

    return errors
  }

  /**
   * Validate section 2 (Governance)
   */
  const validateSection2 = (data: any): string[] => {
    const errors: string[] = []

    if (data.total_board_members) {
      errors.push(...validateInteger(data.total_board_members, 'Total board members'))
    }

    if (data.female_board_percentage) {
      errors.push(...validatePercentage(data.female_board_percentage, 'Female board percentage'))
    }

    if (data.anti_corruption_training_rate) {
      errors.push(...validatePercentage(data.anti_corruption_training_rate, 'Anti-corruption training rate'))
    }

    if (data.esg_awareness_training_rate) {
      errors.push(...validatePercentage(data.esg_awareness_training_rate, 'ESG awareness training rate'))
    }

    if (data.whistleblower_reports_filed) {
      errors.push(...validateInteger(data.whistleblower_reports_filed, 'Whistleblower reports filed'))
    }

    return errors
  }

  /**
   * Validate section 3 (Environment)
   */
  const validateSection3 = (data: any): string[] => {
    const errors: string[] = []

    if (data.ghg_scope1_emissions) {
      errors.push(...validateNonNegativeNumber(data.ghg_scope1_emissions, 'GHG Scope 1 emissions'))
    }

    if (data.ghg_scope2_emissions) {
      errors.push(...validateNonNegativeNumber(data.ghg_scope2_emissions, 'GHG Scope 2 emissions'))
    }

    if (data.ghg_scope3_emissions) {
      errors.push(...validateNonNegativeNumber(data.ghg_scope3_emissions, 'GHG Scope 3 emissions'))
    }

    if (data.renewable_energy_percentage) {
      errors.push(...validatePercentage(data.renewable_energy_percentage, 'Renewable energy percentage'))
    }

    if (data.waste_reduction_rate) {
      errors.push(...validatePercentage(data.waste_reduction_rate, 'Waste reduction rate'))
    }

    if (data.water_consumption) {
      errors.push(...validateNonNegativeNumber(data.water_consumption, 'Water consumption'))
    }

    return errors
  }

  /**
   * Validate section 4 (Social)
   */
  const validateSection4 = (data: any): string[] => {
    const errors: string[] = []

    if (data.gender_pay_gap_percentage !== undefined && data.gender_pay_gap_percentage !== null) {
      if (typeof data.gender_pay_gap_percentage !== 'number') {
        errors.push('Gender pay gap percentage must be a number')
      }
      else if (data.gender_pay_gap_percentage < -100 || data.gender_pay_gap_percentage > 100) {
        errors.push('Gender pay gap percentage must be between -100 and 100')
      }
    }

    if (data.female_employees_percentage) {
      errors.push(...validatePercentage(data.female_employees_percentage, 'Female employees percentage'))
    }

    if (data.female_management_percentage) {
      errors.push(...validatePercentage(data.female_management_percentage, 'Female management percentage'))
    }

    if (data.health_safety_incidents) {
      errors.push(...validateInteger(data.health_safety_incidents, 'Health safety incidents'))
    }

    if (data.employee_turnover_rate) {
      errors.push(...validatePercentage(data.employee_turnover_rate, 'Employee turnover rate'))
    }

    if (data.employee_satisfaction_score) {
      errors.push(...validatePercentage(data.employee_satisfaction_score, 'Employee satisfaction score'))
    }

    return errors
  }

  /**
   * Validate section 5 (Cybersecurity)
   */
  const validateSection5 = (data: any): string[] => {
    const errors: string[] = []

    if (data.cybersecurity_training_rate) {
      errors.push(...validatePercentage(data.cybersecurity_training_rate, 'Cybersecurity training rate'))
    }

    if (data.data_breach_incidents) {
      errors.push(...validateInteger(data.data_breach_incidents, 'Data breach incidents'))
    }

    return errors
  }

  /**
   * Validate section 6 (Supply Chain)
   */
  const validateSection6 = (data: any): string[] => {
    const errors: string[] = []

    if (data.supplier_audit_rate) {
      errors.push(...validatePercentage(data.supplier_audit_rate, 'Supplier audit rate'))
    }

    if (data.ethical_sourcing_percentage) {
      errors.push(...validatePercentage(data.ethical_sourcing_percentage, 'Ethical sourcing percentage'))
    }

    if (data.supplier_diversity_percentage) {
      errors.push(...validatePercentage(data.supplier_diversity_percentage, 'Supplier diversity percentage'))
    }

    return errors
  }

  /**
   * Validate section 7 (Targets)
   */
  const validateSection7 = (data: any): string[] => {
    const errors: string[] = []

    if (data.emission_reduction_target) {
      errors.push(...validatePercentage(data.emission_reduction_target, 'Emission reduction target'))
    }

    if (data.emission_reduction_target_year) {
      errors.push(...validateYear(data.emission_reduction_target_year, 'Emission reduction target year'))
    }

    if (data.renewable_energy_target) {
      errors.push(...validatePercentage(data.renewable_energy_target, 'Renewable energy target'))
    }

    if (data.renewable_energy_target_year) {
      errors.push(...validateYear(data.renewable_energy_target_year, 'Renewable energy target year'))
    }

    if (data.diversity_target_female_management) {
      errors.push(...validatePercentage(data.diversity_target_female_management, 'Diversity target female management'))
    }

    if (data.diversity_target_year) {
      errors.push(...validateYear(data.diversity_target_year, 'Diversity target year'))
    }

    return errors
  }

  /**
   * Validate step based on step number
   */
  const validateStep = (stepNumber: number, data: any): string[] => {
    switch (stepNumber) {
      case 1:
        return validateMetadata(data)
      case 2:
        return validateSection1(data)
      case 3:
        return validateSection2(data)
      case 4:
        return validateSection3(data)
      case 5:
        return validateSection4(data)
      case 6:
        return validateSection5(data)
      case 7:
        return validateSection6(data)
      case 8:
        return validateSection7(data)
      case 9:
        // Frameworks/certifications validation (optional, could require at least one)
        return []
      default:
        return []
    }
  }

  /**
   * Validate entire form
   */
  const validateForm = (formData: ReportFormData): Record<number, string[]> => {
    const allErrors: Record<number, string[]> = {}

    allErrors[1] = validateMetadata(formData.metadata)
    allErrors[2] = validateSection1(formData.section1)
    allErrors[3] = validateSection2(formData.section2)
    allErrors[4] = validateSection3(formData.section3)
    allErrors[5] = validateSection4(formData.section4)
    allErrors[6] = validateSection5(formData.section5)
    allErrors[7] = validateSection6(formData.section6)
    allErrors[8] = validateSection7(formData.section7)
    allErrors[9] = []

    return allErrors
  }

  /**
   * Check if a step is valid
   */
  const isStepValid = (stepNumber: number, data: any): boolean => {
    return validateStep(stepNumber, data).length === 0
  }

  /**
   * Check if entire form is valid
   */
  const isFormValid = (formData: ReportFormData): boolean => {
    const errors = validateForm(formData)
    return Object.values(errors).every(stepErrors => stepErrors.length === 0)
  }

  return {
    validateMetadata,
    validatePercentage,
    validateNonNegativeNumber,
    validateInteger,
    validateYear,
    validateSection1,
    validateSection2,
    validateSection3,
    validateSection4,
    validateSection5,
    validateSection6,
    validateSection7,
    validateStep,
    validateForm,
    isStepValid,
    isFormValid,
  }
}
