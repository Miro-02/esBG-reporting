<template>
  <div v-if="!isAuthenticated" class="auth-guard">
    <p>Please log in to create a report.</p>
  </div>
  <div v-else-if="isLoading" class="loading-page">
    <div class="spinner" />
    <p>Loading...</p>
  </div>
  <ReportWizardContainer v-else :is-saving="isSaving" @next-step="handleNextStep" @complete="handleComplete">
    <template #default="{ step }">
      <ReportStep1 v-if="step === 1" ref="step1Ref" />
      <ReportStep2 v-else-if="step === 2" ref="step2Ref" />
      <ReportStep3 v-else-if="step === 3" ref="step3Ref" />
      <ReportStep4 v-else-if="step === 4" ref="step4Ref" />
      <ReportStep5 v-else-if="step === 5" ref="step5Ref" />
      <ReportStep6 v-else-if="step === 6" ref="step6Ref" />
      <ReportStep7 v-else-if="step === 7" ref="step7Ref" />
      <ReportStep8 v-else-if="step === 8" ref="step8Ref" />
      <ReportStep9 v-else-if="step === 9" ref="step9Ref" />
    </template>
  </ReportWizardContainer>

  <!-- Unsaved changes dialog -->
  <Teleport to="body">
    <div v-if="showUnsavedDialog" class="modal-overlay" @click.self="cancelNavigation">
      <div class="modal-content">
        <h2>Unsaved Changes</h2>
        <p>You have unsaved changes. Are you sure you want to leave?</p>
        <div class="modal-actions">
          <button class="btn btn-secondary" @click="cancelNavigation">
            Cancel
          </button>
          <button class="btn btn-danger" @click="confirmNavigation">
            Leave
          </button>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '~/stores/auth'
import { useReportFormStore } from '~/stores/reportForm'
import { useReportApi } from '~/composables/useReportApi'
import { STEP_CONFIGS } from '~/types/report'
import ReportWizardContainer from '~/components/ReportWizardContainer.vue'
import ReportStep1 from '~/components/ReportStep1.vue'
import ReportStep2 from '~/components/ReportStep2.vue'
import ReportStep3 from '~/components/ReportStep3.vue'
import ReportStep4 from '~/components/ReportStep4.vue'
import ReportStep5 from '~/components/ReportStep5.vue'
import ReportStep6 from '~/components/ReportStep6.vue'
import ReportStep7 from '~/components/ReportStep7.vue'
import ReportStep8 from '~/components/ReportStep8.vue'
import ReportStep9 from '~/components/ReportStep9.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const formStore = useReportFormStore()
const { createReport, getReport, updateSection, updateFrameworks, updateCertifications } = useReportApi()

const isLoading = ref(false)
const isSaving = ref(false)
const showUnsavedDialog = ref(false)
let pendingNavigation: string | null = null

const isAuthenticated = computed(() => authStore.isLoggedIn)

/**
 * Initialize form on page load
 */
onMounted(async () => {
  // Check if user is authenticated
  if (!isAuthenticated.value) {
    router.push('/login')
    return
  }

  // Check if resuming an existing report
  const reportId = route.query.reportId as string | undefined
  if (reportId) {
    isLoading.value = true
    try {
      const report = await getReport(parseInt(reportId))
      formStore.loadReportData(report)
    }
    catch (error) {
      console.error('Failed to load report:', error)
      formStore.initializeForm()
    }
    finally {
      isLoading.value = false
    }
  }
  else {
    formStore.initializeForm()
  }

  // Setup beforeunload listener for unsaved changes
  window.addEventListener('beforeunload', handleBeforeUnload)
})

onBeforeUnmount(() => {
  window.removeEventListener('beforeunload', handleBeforeUnload)
})

/**
 * Handle browser back/refresh with unsaved changes
 */
const handleBeforeUnload = (e: BeforeUnloadEvent) => {
  if (formStore.hasUnsavedChanges) {
    e.preventDefault()
    e.returnValue = ''
  }
}

/**
 * Handle next step button click
 * Validates current step and saves to API
 */
const handleNextStep = async () => {
  try {
    isSaving.value = true
    const currentStep = formStore.currentStep

    formStore.startSavingStep(currentStep)

    // Step 1: Create or update metadata
    if (currentStep === 1) {
      if (!formStore.reportId) {
        // First time: create the report
        const report = await createReport(formStore.formData.metadata)
        formStore.setReportId(report.id)
      }
      else {
        // Update metadata
        await updateSection(formStore.reportId, 0, formStore.formData.metadata)
      }
    }
    // Steps 2-8: Update sections
    else if (currentStep >= 2 && currentStep <= 8) {
      if (formStore.reportId) {
        const sectionData = formStore.getSectionData(currentStep - 1)
        await updateSection(formStore.reportId, currentStep - 1, sectionData)
      }
    }
    // Step 9: Update frameworks and certifications
    else if (currentStep === 9) {
      if (formStore.reportId) {
        const { frameworks, certifications } = formStore.formData.frameworks_certifications
        await Promise.all([
          updateFrameworks(formStore.reportId, frameworks),
          updateCertifications(formStore.reportId, certifications),
        ])
      }
    }

    formStore.completeSaveStep(currentStep)

    // Move to next step
    if (currentStep < 9) {
      formStore.goToNextStep()
    }
  }
  catch (error: any) {
    const errorMessage = error.message || 'Failed to save step'
    formStore.failSaveStep(formStore.currentStep, errorMessage)
    console.error('Save failed:', error)
  }
  finally {
    isSaving.value = false
  }
}

/**
 * Handle completion of the form
 */
const handleComplete = async () => {
  try {
    // All steps completed, redirect to report detail
    if (formStore.reportId) {
      await router.push(`/reports/${formStore.reportId}`)
    }
  }
  catch (error) {
    console.error('Failed to complete form:', error)
  }
}

/**
 * Cancel unsaved navigation
 */
const cancelNavigation = () => {
  showUnsavedDialog.value = false
  pendingNavigation = null
}

/**
 * Confirm unsaved navigation
 */
const confirmNavigation = async () => {
  showUnsavedDialog.value = false
  if (pendingNavigation) {
    formStore.setUnsavedChanges(false)
    await router.push(pendingNavigation)
  }
  pendingNavigation = null
}

/**
 * Route guard for unsaved changes
 */
router.beforeEach((to, from, next) => {
  // Only warn if leaving the form page with unsaved changes
  if (from.path === '/reports/create' && formStore.hasUnsavedChanges) {
    showUnsavedDialog.value = true
    pendingNavigation = to.path
    next(false)
  }
  else {
    next()
  }
})
</script>

<style scoped>
.auth-guard,
.loading-page {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  gap: 1rem;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #e5e7eb;
  border-top-color: #1e3a8a;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Modal Dialog */
/* ────────────────────────────────────────────────────────────────────────── */

.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.modal-content {
  background: white;
  border-radius: 0.5rem;
  padding: 2rem;
  max-width: 400px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
  animation: slideUp 0.2s ease;
}

@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.modal-content h2 {
  margin: 0 0 0.5rem 0;
  font-size: 1.25rem;
  color: #1f2937;
}

.modal-content p {
  margin: 0 0 1.5rem 0;
  color: #6b7280;
  line-height: 1.5;
}

.modal-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

.btn {
  padding: 0.625rem 1.5rem;
  border: none;
  border-radius: 0.375rem;
  font-size: 0.9375rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-secondary {
  background: #e5e7eb;
  color: #374151;
}

.btn-secondary:hover {
  background: #d1d5db;
}

.btn-danger {
  background: #ef4444;
  color: white;
}

.btn-danger:hover {
  background: #dc2626;
}
</style>
