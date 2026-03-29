<template>
  <ReportStepBase
    title="Personal Information"
    description="Report metadata and basic information"
    :is-loading="saveState.isLoading"
    :has-errors="errors.length > 0"
    :error-message="errors[0]"
  >
    <div class="form-grid">
      <!-- Report Name -->
      <div class="form-group full-width">
        <label for="name" class="form-label required">
          Report Name
        </label>
        <input
          id="name"
          v-model="formStore.formData.metadata.name"
          type="text"
          class="form-input"
          :class="{ 'has-error': getFieldErrors('name').length > 0 }"
          placeholder="E.g., Q1 2024 ESG Report"
          maxlength="255"
          @blur="validateField('name')"
        />
        <span
          v-for="error in getFieldErrors('name')"
          :key="error"
          class="field-error"
        >
          {{ error }}
        </span>
      </div>

      <!-- Description -->
      <div class="form-group full-width">
        <label for="description" class="form-label">Description (Optional)</label>
        <textarea
          id="description"
          v-model="formStore.formData.metadata.description"
          class="form-textarea"
          placeholder="Add notes about this report"
          rows="4"
          maxlength="5000"
        />
        <span class="char-count">
          {{ (formStore.formData.metadata.description || '').length }} / 5000
        </span>
      </div>

      <!-- Start Date -->
      <div class="form-group">
        <label for="start_date" class="form-label required">
          Start Date
        </label>
        <input
          id="start_date"
          v-model="formStore.formData.metadata.start_date"
          type="date"
          class="form-input"
          :class="{ 'has-error': getFieldErrors('start_date').length > 0 }"
          @blur="validateField('start_date')"
        />
        <span
          v-for="error in getFieldErrors('start_date')"
          :key="error"
          class="field-error"
        >
          {{ error }}
        </span>
      </div>

      <!-- End Date -->
      <div class="form-group">
        <label for="end_date" class="form-label required">
          End Date
        </label>
        <input
          id="end_date"
          v-model="formStore.formData.metadata.end_date"
          type="date"
          class="form-input"
          :class="{ 'has-error': getFieldErrors('end_date').length > 0 }"
          @blur="validateField('end_date')"
        />
        <span
          v-for="error in getFieldErrors('end_date')"
          :key="error"
          class="field-error"
        >
          {{ error }}
        </span>
      </div>
    </div>

    <!-- Info box -->
    <div class="info-box">
      <span class="info-icon">ℹ</span>
      <p class="info-text">
        This information will help identify and organize your ESG report. You can edit
        these details later if needed.
      </p>
    </div>
  </ReportStepBase>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useReportFormStore } from '~/stores/reportForm'
import { useReportValidation } from '~/composables/useReportValidation'
import ReportStepBase from '~/components/ReportStepBase.vue'

const formStore = useReportFormStore()
const { validateMetadata } = useReportValidation()

const errors = ref<string[]>([])

const savedErrors = computed(() => {
  const metadata = formStore.formData.metadata
  return validateMetadata(metadata)
})

const saveState = computed(() => {
  return formStore.saveStates[1] || { isLoading: false, error: null, success: false }
})

/**
 * Get errors for a specific field
 */
const getFieldErrors = (field: string): string[] => {
  return savedErrors.value.filter((error) => {
    // Simple field matching - in production you'd want more sophisticated error handling
    return (
      (field === 'name' && error.includes('name')) ||
      (field === 'start_date' && error.includes('start')) ||
      (field === 'end_date' && error.includes('end'))
    )
  })
}

/**
 * Validate a specific field
 */
const validateField = (field: string) => {
  const metadata = formStore.formData.metadata
  const fieldErrors = getFieldErrors(field)

  if (fieldErrors.length > 0) {
    errors.value = fieldErrors
  }
  else {
    errors.value = errors.value.filter(
      err =>
        !err.includes(field.charAt(0).toUpperCase() + field.slice(1)),
    )
  }
}

/**
 * Check if the step is valid before proceeding
 */
const isStepValid = computed(() => {
  return savedErrors.value.length === 0
})

/**
 * Expose the validation result for parent component
 */
defineExpose({
  isStepValid,
})
</script>

<style scoped>
.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

.form-label {
  font-size: 0.9375rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.form-label.required::after {
  content: " *";
  color: #ef4444;
}

.form-input,
.form-textarea {
  padding: 0.625rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  font-size: 0.9375rem;
  font-family: inherit;
  transition: all 0.2s ease;
}

.form-input:focus,
.form-textarea:focus {
  outline: none;
  border-color: #1e3a8a;
  box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
}

.form-input.has-error,
.form-textarea.has-error {
  border-color: #ef4444;
  background: #fef2f2;
}

.form-input.has-error:focus,
.form-textarea.has-error:focus {
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.form-textarea {
  resize: vertical;
  min-height: 100px;
}

.field-error {
  font-size: 0.8125rem;
  color: #ef4444;
  margin-top: 0.375rem;
  display: block;
}

.char-count {
  font-size: 0.8125rem;
  color: #9ca3af;
  margin-top: 0.375rem;
  text-align: right;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Info Box */
/* ────────────────────────────────────────────────────────────────────────── */

.info-box {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  border-radius: 0.5rem;
  margin-top: 2rem;
}

.info-icon {
  font-size: 1.25rem;
  flex-shrink: 0;
}

.info-text {
  margin: 0;
  font-size: 0.9375rem;
  color: #1e40af;
  line-height: 1.5;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Responsive */
/* ────────────────────────────────────────────────────────────────────────── */

@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .form-group.full-width {
    grid-column: 1;
  }
}
</style>
