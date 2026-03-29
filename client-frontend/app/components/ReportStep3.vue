<template>
  <ReportStepBase
    title="Governance"
    description="Board composition and governance structure"
    :is-loading="saveState.isLoading"
    :has-errors="errors.length > 0"
    :error-message="errors[0]"
  >
    <div class="form-grid">
      <!-- Total Board Members -->
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
        <span v-for="error in getFieldErrors('total_board_members')" :key="error" class="field-error">{{ error }}</span>
      </div>

      <!-- Female Board Percentage -->
      <div class="form-group">
        <label for="female_board_percentage" class="form-label">Female Board Percentage (Optional)</label>
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
        <span v-for="error in getFieldErrors('female_board_percentage')" :key="error" class="field-error">{{ error }}</span>
      </div>

      <!-- ESG Committee Exists -->
      <div class="form-group">
        <label for="esg_committee_exists" class="form-label">ESG Committee Exists (Optional)</label>
        <div class="checkbox-group">
          <input
            id="esg_committee_exists"
            v-model="formStore.formData.section2.esg_committee_exists"
            type="checkbox"
            class="form-checkbox"
            @change="validateField('esg_committee_exists')"
          />
          <label for="esg_committee_exists" class="checkbox-label">Committee in place</label>
        </div>
      </div>

      <!-- ESG Committee Frequency -->
      <div class="form-group">
        <label for="esg_committee_frequency" class="form-label">ESG Committee Frequency (Optional)</label>
        <input
          id="esg_committee_frequency"
          v-model="formStore.formData.section2.esg_committee_frequency"
          type="text"
          class="form-input"
          placeholder="E.g., Monthly, Quarterly"
          maxlength="255"
          @blur="validateField('esg_committee_frequency')"
        />
      </div>

      <!-- ESG Executive Role -->
      <div class="form-group full-width">
        <label for="esg_executive_role" class="form-label">ESG Executive Role (Optional)</label>
        <input
          id="esg_executive_role"
          v-model="formStore.formData.section2.esg_executive_role"
          type="text"
          class="form-input"
          placeholder="E.g., Chief Sustainability Officer"
          maxlength="255"
          @blur="validateField('esg_executive_role')"
        />
      </div>

      <!-- Code of Conduct Exists -->
      <div class="form-group">
        <label for="code_of_conduct_exists" class="form-label">Code of Conduct Exists (Optional)</label>
        <div class="checkbox-group">
          <input
            id="code_of_conduct_exists"
            v-model="formStore.formData.section2.code_of_conduct_exists"
            type="checkbox"
            class="form-checkbox"
            @change="validateField('code_of_conduct_exists')"
          />
          <label for="code_of_conduct_exists" class="checkbox-label">Code established</label>
        </div>
      </div>

      <!-- Whistleblower Channel Exists -->
      <div class="form-group">
        <label for="whistleblower_channel_exists" class="form-label">Whistleblower Channel Exists (Optional)</label>
        <div class="checkbox-group">
          <input
            id="whistleblower_channel_exists"
            v-model="formStore.formData.section2.whistleblower_channel_exists"
            type="checkbox"
            class="form-checkbox"
            @change="validateField('whistleblower_channel_exists')"
          />
          <label for="whistleblower_channel_exists" class="checkbox-label">Channel available</label>
        </div>
      </div>

      <!-- Whistleblower Reports Filed -->
      <div class="form-group">
        <label for="whistleblower_reports_filed" class="form-label">Whistleblower Reports Filed (Optional)</label>
        <input
          id="whistleblower_reports_filed"
          v-model.number="formStore.formData.section2.whistleblower_reports_filed"
          type="number"
          class="form-input"
          placeholder="E.g., 5"
          min="0"
          @blur="validateField('whistleblower_reports_filed')"
        />
      </div>

      <!-- Anti-Corruption Training Rate -->
      <div class="form-group">
        <label for="anti_corruption_training_rate" class="form-label">Anti-Corruption Training Rate (Optional)</label>
        <div class="input-with-suffix">
          <input
            id="anti_corruption_training_rate"
            v-model.number="formStore.formData.section2.anti_corruption_training_rate"
            type="number"
            class="form-input"
            placeholder="E.g., 95"
            min="0"
            max="100"
            step="0.01"
            @blur="validateField('anti_corruption_training_rate')"
          />
          <span class="suffix">%</span>
        </div>
      </div>

      <!-- ESG Awareness Training Rate -->
      <div class="form-group">
        <label for="esg_awareness_training_rate" class="form-label">ESG Awareness Training Rate (Optional)</label>
        <div class="input-with-suffix">
          <input
            id="esg_awareness_training_rate"
            v-model.number="formStore.formData.section2.esg_awareness_training_rate"
            type="number"
            class="form-input"
            placeholder="E.g., 85"
            min="0"
            max="100"
            step="0.01"
            @blur="validateField('esg_awareness_training_rate')"
          />
          <span class="suffix">%</span>
        </div>
      </div>
    </div>

    <div class="info-box">
      <span class="info-icon">ℹ</span>
      <p class="info-text">
        This section helps document your company's governance practices, ESG oversight, and ethical standards.
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

.checkbox-group {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.form-checkbox {
  width: 20px;
  height: 20px;
  cursor: pointer;
  accent-color: #1e3a8a;
}

.checkbox-label {
  cursor: pointer;
  font-size: 0.9375rem;
  color: #374151;
  margin: 0;
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

.form-label {
  font-size: 0.9375rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}
</style>
