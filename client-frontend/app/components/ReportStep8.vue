<template>
  <ReportStepBase title="ESG Targets" description="Organization's strategic ESG goals" :is-loading="saveState.isLoading" :has-errors="errors.length > 0" :error-message="errors[0]">
    <div class="form-grid">
      <div class="form-group"><label for="emission_reduction_target" class="form-label">Emission Reduction Target (%)</label><div class="input-with-suffix"><input id="emission_reduction_target" v-model.number="formStore.formData.section7.emission_reduction_target" type="number" class="form-input" placeholder="E.g., 30" min="0" max="100" step="0.01" @blur="validateField('emission_reduction_target')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="emission_reduction_target_year" class="form-label">Target Year</label><input id="emission_reduction_target_year" v-model.number="formStore.formData.section7.emission_reduction_target_year" type="number" class="form-input" placeholder="E.g., 2030" min="2024" @blur="validateField('emission_reduction_target_year')" /></div>
      <div class="form-group"><label for="renewable_energy_target" class="form-label">Renewable Energy Target (%)</label><div class="input-with-suffix"><input id="renewable_energy_target" v-model.number="formStore.formData.section7.renewable_energy_target" type="number" class="form-input" placeholder="E.g., 50" min="0" max="100" step="0.01" @blur="validateField('renewable_energy_target')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="renewable_energy_target_year" class="form-label">Target Year</label><input id="renewable_energy_target_year" v-model.number="formStore.formData.section7.renewable_energy_target_year" type="number" class="form-input" placeholder="E.g., 2035" min="2024" @blur="validateField('renewable_energy_target_year')" /></div>
      <div class="form-group"><label for="diversity_target_female_management" class="form-label">Female Management Target (%)</label><div class="input-with-suffix"><input id="diversity_target_female_management" v-model.number="formStore.formData.section7.diversity_target_female_management" type="number" class="form-input" placeholder="E.g., 40" min="0" max="100" step="0.01" @blur="validateField('diversity_target_female_management')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="diversity_target_year" class="form-label">Target Year</label><input id="diversity_target_year" v-model.number="formStore.formData.section7.diversity_target_year" type="number" class="form-input" placeholder="E.g., 2030" min="2024" @blur="validateField('diversity_target_year')" /></div>
      <div class="form-group full-width"><label for="other_targets" class="form-label">Other Targets (Optional)</label><textarea id="other_targets" v-model="formStore.formData.section7.other_targets" class="form-input" placeholder="List any additional ESG targets..." rows="4" maxlength="1000" @blur="validateField('other_targets')" /></div>
    </div>
    <div class="info-box"><span class="info-icon">ℹ</span><p class="info-text">Define your organization's strategic ESG targets and timelines</p></div>
  </ReportStepBase>
</template>
<script setup lang="ts">
import { ref, computed } from 'vue'
import { useReportFormStore } from '~/stores/reportForm'
import { useReportValidation } from '~/composables/useReportValidation'
import ReportStepBase from '~/components/ReportStepBase.vue'
const formStore = useReportFormStore()
const { validateSection7 } = useReportValidation()
const errors = ref<string[]>([])
const saveState = computed(() => formStore.saveStates[8] || { isLoading: false, error: null, success: false })
const getFieldErrors = (field: string): string[] => validateSection7(formStore.formData.section7).filter(error => error.toLowerCase().includes(field.toLowerCase()))
const validateField = (field: string) => { const fieldErrors = getFieldErrors(field); errors.value = fieldErrors.length > 0 ? fieldErrors : errors.value.filter(err => !err.toLowerCase().includes(field.toLowerCase())) }
const isStepValid = computed(() => true)
defineExpose({ isStepValid })
</script>
<style scoped>.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }.form-group { display: flex; flex-direction: column; }.form-group.full-width { grid-column: 1 / -1; }.form-label { font-size: 0.9375rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }.form-input { padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem; font-family: inherit; transition: all 0.2s ease; }.form-input:focus { outline: none; border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); }textarea.form-input { resize: vertical; }.checkbox-group { display: flex; align-items: center; gap: 0.75rem; }.form-checkbox { width: 20px; height: 20px; cursor: pointer; accent-color: #1e3a8a; }.checkbox-label { cursor: pointer; font-size: 0.9375rm; color: #374151; margin: 0; }.input-with-suffix { position: relative; display: flex; align-items: center; }.input-with-suffix .form-input { flex: 1; padding-right: 2.5rem; }.suffix { position: absolute; right: 0.75rem; color: #9ca3af; font-weight: 500; pointer-events: none; }.info-box { display: flex; gap: 1rem; padding: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; margin-top: 2rem; }.info-icon { font-size: 1.25rem; flex-shrink: 0; }.info-text { margin: 0; font-size: 0.9375rem; color: #1e40af; line-height: 1.5; }@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; gap: 1rem; } }</style>
