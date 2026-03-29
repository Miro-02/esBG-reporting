/**
 * Report Form Pinia Store
 * Manages the state of the multi-step report creation form
 */

import { defineStore } from 'pinia'
import type {
  ReportFormData,
  ReportMetadata,
  ReportSection1,
  ReportSection2,
  ReportSection3,
  ReportSection4,
  ReportSection5,
  ReportSection6,
  ReportSection7,
  SaveStates,
  FormValidationError,
} from '~/types/report'

interface ReportFormState {
  // Report metadata
  reportId: number | null
  
  // Current step (0-9)
  currentStep: number
  
  // Form data for all steps
  formData: ReportFormData
  
  // Saving states per step
  saveStates: SaveStates
  
  // Validation errors
  validationErrors: FormValidationError[]
  
  // Track which steps have been completed
  completedSteps: Set<number>
  
  // Unsaved changes flag
  hasUnsavedChanges: boolean
  
  // Global loading state
  isLoading: boolean
  
  // Form-level error message
  errorMessage: string | null
}

export const useReportFormStore = defineStore('report-form', () => {
  // ──────────────────────────────────────────────────────────────────────────
  // State
  // ──────────────────────────────────────────────────────────────────────────

  const reportId = ref<number | null>(null)
  const currentStep = ref(1)
  const hasUnsavedChanges = ref(false)
  const isLoading = ref(false)
  const errorMessage = ref<string | null>(null)
  const validationErrors = ref<FormValidationError[]>([])
  const completedSteps = ref<Set<number>>(new Set())

  const formData = ref<ReportFormData>({
    metadata: {
      name: '',
      description: '',
      start_date: '',
      end_date: '',
    },
    section1: {},
    section2: {},
    section3: {},
    section4: {},
    section5: {},
    section6: {},
    section7: {},
    frameworks_certifications: {
      frameworks: [],
      certifications: [],
    },
  })

  const saveStates = ref<SaveStates>({
    1: { isLoading: false, error: null, success: false },
    2: { isLoading: false, error: null, success: false },
    3: { isLoading: false, error: null, success: false },
    4: { isLoading: false, error: null, success: false },
    5: { isLoading: false, error: null, success: false },
    6: { isLoading: false, error: null, success: false },
    7: { isLoading: false, error: null, success: false },
    8: { isLoading: false, error: null, success: false },
    9: { isLoading: false, error: null, success: false },
  })

  // ──────────────────────────────────────────────────────────────────────────
  // Utility Methods
  // ──────────────────────────────────────────────────────────────────────────

  /**
   * Initialize the form with empty or provided data
   */
  const initializeForm = (initialData?: Partial<ReportFormData>) => {
    if (initialData) {
      formData.value = {
        ...formData.value,
        ...initialData,
      }
    }
    reportId.value = null
    currentStep.value = 1
    hasUnsavedChanges.value = false
    errorMessage.value = null
    validationErrors.value = []
    completedSteps.value = new Set()
  }

  /**
   * Load an existing report's data
   */
  const loadReportData = (data: any) => {
    reportId.value = data.id
    formData.value = {
      metadata: {
        name: data.name || '',
        description: data.description || '',
        start_date: data.start_date || '',
        end_date: data.end_date || '',
      },
      section1: data.section1 || {},
      section2: data.section2 || {},
      section3: data.section3 || {},
      section4: data.section4 || {},
      section5: data.section5 || {},
      section6: data.section6 || {},
      section7: data.section7 || {},
      frameworks_certifications: {
        frameworks: data.frameworks?.map((f: any) => f.id) || [],
        certifications: data.certifications?.map((c: any) => c.id) || [],
      },
    }
    
    // Mark steps as completed if they have data
    if (data.section1 && Object.keys(data.section1).length > 0) completedSteps.value.add(2)
    if (data.section2 && Object.keys(data.section2).length > 0) completedSteps.value.add(3)
    if (data.section3 && Object.keys(data.section3).length > 0) completedSteps.value.add(4)
    if (data.section4 && Object.keys(data.section4).length > 0) completedSteps.value.add(5)
    if (data.section5 && Object.keys(data.section5).length > 0) completedSteps.value.add(6)
    if (data.section6 && Object.keys(data.section6).length > 0) completedSteps.value.add(7)
    if (data.section7 && Object.keys(data.section7).length > 0) completedSteps.value.add(8)
    
    hasUnsavedChanges.value = false
  }

  /**
   * Set current step with validation
   */
  const setCurrentStep = (step: number) => {
    if (step >= 1 && step <= 9) {
      currentStep.value = step
    }
  }

  /**
   * Move to next step
   */
  const goToNextStep = () => {
    if (currentStep.value < 9) {
      currentStep.value += 1
    }
  }

  /**
   * Move to previous step
   */
  const goToPreviousStep = () => {
    if (currentStep.value > 1) {
      currentStep.value -= 1
    }
  }

  // ──────────────────────────────────────────────────────────────────────────
  // Data Update Methods
  // ──────────────────────────────────────────────────────────────────────────

  /**
   * Update metadata (step 1)
   */
  const updateMetadata = (data: Partial<ReportMetadata>) => {
    formData.value.metadata = {
      ...formData.value.metadata,
      ...data,
    }
    setUnsavedChanges(true)
  }

  /**
   * Update a specific section's data
   */
  const updateSectionData = (sectionNumber: number, data: any) => {
    const sectionKey = `section${sectionNumber}` as keyof ReportFormData
    if (sectionKey in formData.value) {
      formData.value[sectionKey] = {
        ...formData.value[sectionKey],
        ...data,
      }
      setUnsavedChanges(true)
    }
  }

  /**
   * Update frameworks and certifications
   */
  const updateFrameworksCertifications = (frameworks: number[], certifications: number[]) => {
    formData.value.frameworks_certifications = {
      frameworks,
      certifications,
    }
    setUnsavedChanges(true)
  }

  /**
   * Set unsaved changes flag
   */
  const setUnsavedChanges = (value: boolean) => {
    hasUnsavedChanges.value = value
  }

  // ──────────────────────────────────────────────────────────────────────────
  // Saving Methods
  // ──────────────────────────────────────────────────────────────────────────

  /**
   * Set report ID after creating new report
   */
  const setReportId = (id: number) => {
    reportId.value = id
  }

  /**
   * Mark a step as completed
   */
  const markStepCompleted = (step: number) => {
    completedSteps.value.add(step)
  }

  /**
   * Mark a step as having save in progress
   */
  const startSavingStep = (step: number) => {
    if (saveStates.value[step]) {
      saveStates.value[step].isLoading = true
      saveStates.value[step].error = null
      saveStates.value[step].success = false
    }
  }

  /**
   * Mark a step save as completed successfully
   */
  const completeSaveStep = (step: number) => {
    if (saveStates.value[step]) {
      saveStates.value[step].isLoading = false
      saveStates.value[step].error = null
      saveStates.value[step].success = true
    }
    markStepCompleted(step)
    setUnsavedChanges(false)
  }

  /**
   * Mark a step save as failed
   */
  const failSaveStep = (step: number, error: string) => {
    if (saveStates.value[step]) {
      saveStates.value[step].isLoading = false
      saveStates.value[step].error = error
      saveStates.value[step].success = false
    }
  }

  /**
   * Reset save states
   */
  const resetSaveStates = () => {
    Object.keys(saveStates.value).forEach((key) => {
      const step = parseInt(key)
      saveStates.value[step] = {
        isLoading: false,
        error: null,
        success: false,
      }
    })
  }

  // ──────────────────────────────────────────────────────────────────────────
  // Validation Methods
  // ──────────────────────────────────────────────────────────────────────────

  /**
   * Add a validation error
   */
  const addValidationError = (field: string, message: string) => {
    validationErrors.value.push({ field, message })
  }

  /**
   * Clear all validation errors
   */
  const clearValidationErrors = () => {
    validationErrors.value = []
  }

  /**
   * Get validation errors for a specific field
   */
  const getFieldErrors = (field: string): string[] => {
    return validationErrors.value
      .filter(err => err.field === field)
      .map(err => err.message)
  }

  /**
   * Set error message
   */
  const setErrorMessage = (message: string | null) => {
    errorMessage.value = message
  }

  // ──────────────────────────────────────────────────────────────────────────
  // Computed Properties
  // ──────────────────────────────────────────────────────────────────────────

  /**
   * Check if current step is completed
   */
  const isCurrentStepCompleted = computed(() => {
    return completedSteps.value.has(currentStep.value)
  })

  /**
   * Check if step is completed
   */
  const isStepCompleted = computed(() => {
    return (step: number) => completedSteps.value.has(step)
  })

  /**
   * Get current save state
   */
  const getCurrentSaveState = computed(() => {
    return saveStates.value[currentStep.value] || { isLoading: false, error: null, success: false }
  })

  /**
   * Get currently saving step number (for loading indicators)
   */
  const getSavingStepNumber = computed(() => {
    for (const step in saveStates.value) {
      const stepNum = parseInt(step)
      if (saveStates.value[stepNum]?.isLoading) {
        return stepNum
      }
    }
    return null
  })

  /**
   * Check if any step is currently saving
   */
  const isSavingAnyStep = computed(() => {
    return Object.values(saveStates.value).some(state => state.isLoading)
  })

  /**
   * Get percentage of completion
   */
  const completionPercentage = computed(() => {
    return Math.round((completedSteps.value.size / 9) * 100)
  })

  /**
   * Check if all steps are completed
   */
  const isFormComplete = computed(() => {
    return completedSteps.value.size === 9
  })

  /**
   * Get metadata for display
   */
  const getMetadata = computed(() => {
    return formData.value.metadata
  })

  /**
   * Get section data
   */
  const getSectionData = (sectionNumber: number) => {
    return formData.value[`section${sectionNumber}` as keyof ReportFormData] || {}
  }

  return {
    // State
    reportId,
    currentStep,
    formData,
    saveStates,
    validationErrors,
    completedSteps,
    hasUnsavedChanges,
    isLoading,
    errorMessage,

    // Core methods
    initializeForm,
    loadReportData,
    setCurrentStep,
    goToNextStep,
    goToPreviousStep,

    // Data updates
    updateMetadata,
    updateSectionData,
    updateFrameworksCertifications,
    setUnsavedChanges,

    // Saving
    setReportId,
    markStepCompleted,
    startSavingStep,
    completeSaveStep,
    failSaveStep,
    resetSaveStates,

    // Validation
    addValidationError,
    clearValidationErrors,
    getFieldErrors,
    setErrorMessage,

    // Computed
    isCurrentStepCompleted,
    isStepCompleted,
    getCurrentSaveState,
    getSavingStepNumber,
    isSavingAnyStep,
    completionPercentage,
    isFormComplete,
    getMetadata,
    getSectionData,
  }
})
