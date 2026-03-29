<template>
  <ReportStepBase
    title="Environment"
    description="Environmental impact and sustainability metrics"
    :is-loading="saveState.isLoading"
    :has-errors="errors.length > 0"
    :error-message="errors[0]"
  >
    <div class="form-grid">
      <div class="form-group">
        <label for="ghg_scope1_emissions" class="form-label">GHG Scope 1 Emissions (Optional)</label>
        <input
          id="ghg_scope1_emissions"
          v-model.number="formStore.formData.section3.ghg_scope1_emissions"
          type="number"
          class="form-input"
          placeholder="Metric tons CO2e"
          min="0"
          step="0.01"
          @blur="validateField('ghg_scope1_emissions')"
        />
      </div>

      <div class="form-group">
        <label for="ghg_scope2_emissions" class="form-label">GHG Scope 2 Emissions (Optional)</label>
        <input
          id="ghg_scope2_emissions"
          v-model.number="formStore.formData.section3.ghg_scope2_emissions"
          type="number"
          class="form-input"
          placeholder="Metric tons CO2e"
          min="0"
          step="0.01"
          @blur="validateField('ghg_scope2_emissions')"
        />
      </div>

      <div class="form-group">
        <label for="ghg_scope3_emissions" class="form-label">GHG Scope 3 Emissions (Optional)</label>
        <input
          id="ghg_scope3_emissions"
          v-model.number="formStore.formData.section3.ghg_scope3_emissions"
          type="number"
          class="form-input"
          placeholder="Metric tons CO2e"
          min="0"
          step="0.01"
          @blur="validateField('ghg_scope3_emissions')"
        />
      </div>

      <div class="form-group">
        <label for="renewable_energy_percentage" class="form-label">Renewable Energy Percentage (Optional)</label>
        <div class="input-with-suffix">
          <input
            id="renewable_energy_percentage"
            v-model.number="formStore.formData.section3.renewable_energy_percentage"
            type="number"
            class="form-input"
            placeholder="E.g., 45"
            min="0"
            max="100"
            step="0.01"
            @blur="validateField('renewable_energy_percentage')"
          />
          <span class="suffix">%</span>
        </div>
      </div>

      <div class="form-group">
        <label for="waste_reduction_rate" class="form-label">Waste Reduction Rate (Optional)</label>
        <div class="input-with-suffix">
          <input
            id="waste_reduction_rate"
            v-model.number="formStore.formData.section3.waste_reduction_rate"
            type="number"
            class="form-input"
            placeholder="E.g., 20"
            min="0"
            max="100"
            step="0.01"
            @blur="validateField('waste_reduction_rate')"
          />
          <span class="suffix">%</span>
        </div>
      </div>

      <div class="form-group">
        <label for="water_consumption" class="form-label">Water Consumption (Optional)</label>
        <input
          id="water_consumption"
          v-model.number="formStore.formData.section3.water_consumption"
          type="number"
          class="form-input"
          placeholder="Cubic meters"
          min="0"
          step="0.01"
          @blur="validateField('water_consumption')"
        />
      </div>

      <div class="form-group">
        <label for="environmental_certification_exists" class="form-label">Environmental Certification (Optional)</label>
        <div class="checkbox-group">
          <input
            id="environmental_certification_exists"
            v-model="formStore.formData.section3.environmental_certification_exists"
            type="checkbox"
            class="form-checkbox"
            @change="validateField('environmental_certification_exists')"
          />
          <label for="environmental_certification_exists" class="checkbox-label">ISO 14001 or equivalent</label>
        </div>
      </div>
    </div>

    <div class="info-box">
      <span class="info-icon">ℹ</span>
      <p class="info-text">Document your environmental metrics and sustainability efforts.</p>
    </div>
  </ReportStepBase>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useReportFormStore } from '~/stores/reportForm'
import { useReportValidation } from '~/composables/useReportValidation'
import ReportStepBase from '~/components/ReportStepBase.vue'

const formStore = useReportFormStore()
const { validateSection3 } = useReportValidation()

const errors = ref<string[]>([])

const savedErrors = computed(() => validateSection3(formStore.formData.section3))
const saveState = computed(() => formStore.saveStates[4] || { isLoading: false, error: null, success: false })

const getFieldErrors = (field: string): string[] => {
  return savedErrors.value.filter(error => error.toLowerCase().includes(field.toLowerCase()))
}

const validateField = (field: string) => {
  const fieldErrors = getFieldErrors(field)
  errors.value = fieldErrors.length > 0 ? fieldErrors : errors.value.filter(err => !err.toLowerCase().includes(field.toLowerCase()))
}

const isStepValid = computed(() => savedErrors.value.length === 0)

defineExpose({ isStepValid })
</script>

<style scoped>
.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
.form-group { display: flex; flex-direction: column; }
.form-label { font-size: 0.9375rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }
.form-input { padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem; transition: all 0.2s ease; }
.form-input:focus { outline: none; border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); }
.checkbox-group { display: flex; align-items: center; gap: 0.75rem; }
.form-checkbox { width: 20px; height: 20px; cursor: pointer; accent-color: #1e3a8a; }
.checkbox-label { cursor: pointer; font-size: 0.9375rem; color: #374151; margin: 0; }
.input-with-suffix { position: relative; display: flex; align-items: center; }
.input-with-suffix .form-input { flex: 1; padding-right: 2.5rem; }
.suffix { position: absolute; right: 0.75rem; color: #9ca3af; font-weight: 500; pointer-events: none; }
.field-error { font-size: 0.8125rem; color: #ef4444; margin-top: 0.375rem; display: block; }
.info-box { display: flex; gap: 1rem; padding: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; margin-top: 2rem; }
.info-icon { font-size: 1.25rem; flex-shrink: 0; }
.info-text { margin: 0; font-size: 0.9375rem; color: #1e40af; line-height: 1.5; }
@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; gap: 1rem; } }
</style>
