<template>
  <div class="report-wizard">
    <!-- Sidebar with step timeline -->
    <div class="wizard-sidebar">
      <div class="sidebar-header">
        <h1 class="sidebar-title">Creating new report</h1>
        <p class="sidebar-subtitle">Create it in 9 steps</p>
      </div>

      <!-- Step timeline -->
      <div class="steps-timeline">
        <div v-for="step in 9" :key="step" class="timeline-item">
          <!-- Timeline dot and connector -->
          <div class="timeline-marker">
            <button
              class="step-dot"
              :class="{ 'is-current': formStore.currentStep === step }"
              @click="formStore.setCurrentStep(step)"
            >
              <span v-if="formStore.currentStep === step" class="checkmark-icon">✓</span>
              <span v-else>{{ step }}</span>
            </button>
            <div v-if="step < 9" class="timeline-connector" />
          </div>

          <!-- Step label -->
          <div class="step-label">
            <p class="step-number">Step {{ step }}</p>
            <p class="step-title">{{ getStepTitle(step) }}</p>
          </div>
        </div>
      </div>

      <!-- Progress indicator -->
      <div class="progress-section">
        <div class="progress-text">
          <p>{{ formStore.completionPercentage }}% Complete</p>
        </div>
        <div class="progress-bar">
          <div
            class="progress-fill"
            :style="{ width: `${formStore.completionPercentage}%` }"
          />
        </div>
      </div>
    </div>

    <!-- Main content area -->
    <div class="wizard-content">
      <!-- Content wrapper with transitions -->
      <Transition name="fade" mode="out-in">
        <div :key="formStore.currentStep" class="step-content">
          <slot :step="formStore.currentStep" :is-saving="isSaving" />
        </div>
      </Transition>

      <!-- Footer with navigation -->
      <div class="wizard-footer">
        <div class="footer-actions">
          <button
            class="btn btn-secondary"
            :disabled="formStore.currentStep === 1 || isSaving"
            @click="formStore.goToPreviousStep"
          >
            ← Back
          </button>

          <div class="save-status">
            <span v-if="isSaving" class="status-loading">
              <span class="spinner" />
              Saving...
            </span>
            <span
              v-else-if="formStore.hasUnsavedChanges"
              class="status-unsaved"
            >
              Unsaved changes
            </span>
            <span v-else class="status-saved">
              ✓ Saved
            </span>
          </div>

          <button
            v-if="formStore.currentStep < 9"
            class="btn btn-primary"
            :disabled="isSaving"
            @click="$emit('next-step')"
          >
            Next →
          </button>
          <button
            v-else
            class="btn btn-success"
            :disabled="isSaving"
            @click="$emit('complete')"
          >
            Complete Report
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useReportFormStore } from '~/stores/reportForm'
import { STEP_CONFIGS } from '~/types/report'

interface Props {
  isSaving?: boolean
}

withDefaults(defineProps<Props>(), {
  isSaving: false,
})

defineEmits<{
  'next-step': []
  'complete': []
}>()

const formStore = useReportFormStore()

const getStepTitle = (step: number): string => {
  return STEP_CONFIGS[step]?.title || `Step ${step}`
}

const isSaving = computed(() => {
  return formStore.isSavingAnyStep
})
</script>

<style scoped>
.report-wizard {
  display: flex;
  height: 100vh;
  background: #f5f7fa;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue',
    Arial, sans-serif;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Sidebar */
/* ────────────────────────────────────────────────────────────────────────── */

.wizard-sidebar {
  width: 280px;
  background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
  color: white;
  padding: 2rem 1.5rem;
  overflow-y: auto;
  border-right: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-header {
  margin-bottom: 2rem;
}

.sidebar-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0 0 0.5rem 0;
  line-height: 1.2;
}

.sidebar-subtitle {
  font-size: 0.875rem;
  opacity: 0.9;
  margin: 0;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Steps Timeline */
/* ────────────────────────────────────────────────────────────────────────── */

.steps-timeline {
  margin-bottom: 2rem;
}

.timeline-item {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
  position: relative;
}

.timeline-marker {
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
}

.step-dot {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.2);
  border: 2px solid rgba(255, 255, 255, 0.3);
  color: white;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.step-dot:hover:not(:disabled) {
  background: rgba(255, 255, 255, 0.3);
  border-color: rgba(255, 255, 255, 0.5);
  transform: scale(1.05);
}

.step-dot.is-current {
  background: white;
  color: #1e3a8a;
  border-color: white;
  box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
}

.step-dot:not(.is-current) {
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(255, 255, 255, 0.3);
}

.step-dot:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.checkmark-icon {
  display: block;
  font-size: 1.25rem;
}

.timeline-connector {
  width: 2px;
  height: 2rem;
  background: rgba(255, 255, 255, 0.2);
  margin-top: 0.5rem;
}

.step-label {
  flex: 1;
  padding-top: 0.25rem;
}

.step-number {
  font-size: 0.75rem;
  opacity: 0.7;
  margin: 0;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.step-title {
  font-size: 0.9375rem;
  font-weight: 500;
  margin: 0.25rem 0 0 0;
  color: white;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Progress */
/* ────────────────────────────────────────────────────────────────────────── */

.progress-section {
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.progress-text {
  font-size: 0.875rem;
  margin-bottom: 0.75rem;
  font-weight: 500;
}

.progress-text p {
  margin: 0;
}

.progress-bar {
  width: 100%;
  height: 6px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background: #10b981;
  transition: width 0.3s ease;
  border-radius: 3px;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Content Area */
/* ────────────────────────────────────────────────────────────────────────── */

.wizard-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 2rem;
  overflow: hidden;
}

.step-content {
  flex: 1;
  overflow-y: auto;
  padding-right: 1rem;
}

.step-content::-webkit-scrollbar {
  width: 6px;
}

.step-content::-webkit-scrollbar-track {
  background: transparent;
}

.step-content::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 3px;
}

.step-content::-webkit-scrollbar-thumb:hover {
  background: #a0aec0;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Footer */
/* ────────────────────────────────────────────────────────────────────────── */

.wizard-footer {
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e2e8f0;
}

.footer-actions {
  display: flex;
  align-items: center;
  gap: 1rem;
  justify-content: space-between;
}

.save-status {
  font-size: 0.875rem;
  font-weight: 500;
  min-width: 120px;
  text-align: center;
}

.status-loading {
  color: #f59e0b;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.spinner {
  display: inline-block;
  width: 14px;
  height: 14px;
  border: 2px solid #f59e0b;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.status-unsaved {
  color: #ef4444;
}

.status-saved {
  color: #10b981;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Buttons */
/* ────────────────────────────────────────────────────────────────────────── */

.btn {
  padding: 0.625rem 1.5rem;
  border: none;
  border-radius: 0.5rem;
  font-size: 0.9375rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-primary {
  background: #1e3a8a;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #1e40af;
  transform: translateY(-1px);
  box-shadow: 0 4px 6px rgba(30, 58, 138, 0.1);
}

.btn-secondary {
  background: #e5e7eb;
  color: #374151;
}

.btn-secondary:hover:not(:disabled) {
  background: #d1d5db;
  transform: translateY(-1px);
}

.btn-success {
  background: #10b981;
  color: white;
}

.btn-success:hover:not(:disabled) {
  background: #059669;
  transform: translateY(-1px);
  box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Transitions */
/* ────────────────────────────────────────────────────────────────────────── */

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Scrollbar */
/* ────────────────────────────────────────────────────────────────────────── */

.wizard-sidebar::-webkit-scrollbar {
  width: 6px;
}

.wizard-sidebar::-webkit-scrollbar-track {
  background: transparent;
}

.wizard-sidebar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 3px;
}

.wizard-sidebar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.3);
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Responsive */
/* ────────────────────────────────────────────────────────────────────────── */

@media (max-width: 1024px) {
  .wizard-sidebar {
    width: 240px;
    padding: 1.5rem 1rem;
  }

  .sidebar-title {
    font-size: 1.25rem;
  }

  .step-title {
    font-size: 0.875rem;
  }
}

@media (max-width: 768px) {
  .report-wizard {
    flex-direction: column;
  }

  .wizard-sidebar {
    width: 100%;
    height: auto;
    padding: 1rem;
    border-right: none;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .steps-timeline {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    margin-bottom: 1rem;
  }

  .timeline-item {
    flex-shrink: 0;
    margin-bottom: 0;
  }

  .step-label {
    display: none;
  }

  .progress-section {
    padding-top: 1rem;
  }

  .wizard-content {
    padding: 1rem;
  }

  .footer-actions {
    flex-direction: column;
  }

  .btn {
    width: 100%;
  }
}
</style>
