<!-- TEMPLATE: Copy this file and replace StepX with the appropriate step number -->
<!-- This template shows the structure for steps 3-9 -->

<template>
  <ReportStepBase
    title="Governance"
    description="Board composition and governance structure"
    :is-loading="saveState.isLoading"
    :has-errors="errors.length > 0"
    :error-message="errors[0]"
  >
    <div class="form-grid">
      <!-- Example: Total Board Members -->
      <div class="form-group">
        <label for="total_board_members" class="form-label">Total Board Members (Optional)</label>
        <input
          id="total_board_members"
          v-model.number="formStore.formData.section2.total_board_members"
          type="number"
          class="form-input"
          placeholder="E.g., 10"
          min="0"
          @blur="validateField('total_board_members')"
        />
        <span
          v-for="error in getFieldErrors('total_board_members')"
          :key="error"
          class="field-error"
        >
          {{ error }}
        </span>
      </div>

      <!-- Example: Female Board Percentage -->
      <div class="form-group">
        <label for="female_board_percentage" class="form-label">
          Female Board Percentage (Optional)
        </label>
        <div class="input-with-suffix">
          <input
            id="female_board_percentage"
            v-model.number="formStore.formData.section2.female_board_percentage"
            type="number"
            class="form-input"
            placeholder="E.g., 30"
            min="0"
            max="100"
            step="0.01"
            @blur="validateField('female_board_percentage')"
          />
          <span class="suffix">%</span>
        </div>
        <span
          v-for="error in getFieldErrors('female_board_percentage')"
          :key="error"
          class="field-error"
        >
          {{ error }}
        </span>
      </div>

      <!-- Add more fields following the same pattern -->
    </div>

    <div class="info-box">
      <span class="info-icon">ℹ</span>
      <p class="info-text">
        This section helps document your company's governance practices and ESG oversight.
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
const { validateSection2 } = useReportValidation()

const errors = ref<string[]>([])

const savedErrors = computed(() => {
  return validateSection2(formStore.formData.section2)
})

const saveState = computed(() => {
  return formStore.saveStates[3] || { isLoading: false, error: null, success: false }
})

const getFieldErrors = (field: string): string[] => {
  return savedErrors.value.filter(error => error.toLowerCase().includes(field.toLowerCase()))
}

const validateField = (field: string) => {
  const fieldErrors = getFieldErrors(field)

  if (fieldErrors.length > 0) {
    errors.value = fieldErrors
  }
  else {
    errors.value = errors.value.filter(
      err => !err.toLowerCase().includes(field.toLowerCase()),
    )
  }
}

const isStepValid = computed(() => {
  return savedErrors.value.length === 0
})

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
}

.form-input {
  padding: 0.625rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  font-size: 0.9375rem;
  font-family: inherit;
  transition: all 0.2s ease;
}

.form-input:focus {
  outline: none;
  border-color: #1e3a8a;
  box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
}

.input-with-suffix {
  position: relative;
  display: flex;
  align-items: center;
}

.input-with-suffix .form-input {
  flex: 1;
  padding-right: 2.5rem;
}

.suffix {
  position: absolute;
  right: 0.75rem;
  color: #9ca3af;
  font-weight: 500;
  pointer-events: none;
}

.field-error {
  font-size: 0.8125rem;
  color: #ef4444;
  margin-top: 0.375rem;
  display: block;
}

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

@media (max-width: 768px) {
  .form-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}
</style>
