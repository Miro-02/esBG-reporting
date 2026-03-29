<template>
  <ReportStepBase title="Social" description="Employee and community impact" :is-loading="saveState.isLoading" :has-errors="errors.length > 0" :error-message="errors[0]">
    <div class="form-grid">
      <div class="form-group"><label for="gender_pay_gap_percentage" class="form-label">Gender Pay Gap (%)</label><div class="input-with-suffix"><input id="gender_pay_gap_percentage" v-model.number="formStore.formData.section4.gender_pay_gap_percentage" type="number" class="form-input" placeholder="E.g., 5" min="-100" max="100" step="0.01" @blur="validateField('gender_pay_gap_percentage')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="female_employees_percentage" class="form-label">Female Employees (%)</label><div class="input-with-suffix"><input id="female_employees_percentage" v-model.number="formStore.formData.section4.female_employees_percentage" type="number" class="form-input" placeholder="E.g., 40" min="0" max="100" step="0.01" @blur="validateField('female_employees_percentage')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="female_management_percentage" class="form-label">Female Management (%)</label><div class="input-with-suffix"><input id="female_management_percentage" v-model.number="formStore.formData.section4.female_management_percentage" type="number" class="form-input" placeholder="E.g., 35" min="0" max="100" step="0.01" @blur="validateField('female_management_percentage')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="health_safety_incidents" class="form-label">Health & Safety Incidents</label><input id="health_safety_incidents" v-model.number="formStore.formData.section4.health_safety_incidents" type="number" class="form-input" placeholder="Number of incidents" min="0" @blur="validateField('health_safety_incidents')" /></div>
      <div class="form-group"><label for="employee_turnover_rate" class="form-label">Employee Turnover Rate (%)</label><div class="input-with-suffix"><input id="employee_turnover_rate" v-model.number="formStore.formData.section4.employee_turnover_rate" type="number" class="form-input" placeholder="E.g., 15" min="0" max="100" step="0.01" @blur="validateField('employee_turnover_rate')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="employee_satisfaction_score" class="form-label">Employee Satisfaction Score</label><div class="input-with-suffix"><input id="employee_satisfaction_score" v-model.number="formStore.formData.section4.employee_satisfaction_score" type="number" class="form-input" placeholder="E.g., 75" min="0" max="100" step="0.01" @blur="validateField('employee_satisfaction_score')" /><span class="suffix">/100</span></div></div>
      <div class="form-group"><label for="diversity_policy_exists" class="form-label">Diversity Policy</label><div class="checkbox-group"><input id="diversity_policy_exists" v-model="formStore.formData.section4.diversity_policy_exists" type="checkbox" class="form-checkbox" @change="validateField('diversity_policy_exists')" /><label for="diversity_policy_exists" class="checkbox-label">Policy in place</label></div></div>
    </div>
    <div class="info-box"><span class="info-icon">ℹ</span><p class="info-text">Document your social and employee metrics</p></div>
  </ReportStepBase>
</template>
<script setup lang="ts">
import { ref, computed } from 'vue'
import { useReportFormStore } from '~/stores/reportForm'
import { useReportValidation } from '~/composables/useReportValidation'
import ReportStepBase from '~/components/ReportStepBase.vue'
const formStore = useReportFormStore()
const { validateSection4 } = useReportValidation()
const errors = ref<string[]>([])
const saveState = computed(() => formStore.saveStates[5] || { isLoading: false, error: null, success: false })
const getFieldErrors = (field: string): string[] => validateSection4(formStore.formData.section4).filter(error => error.toLowerCase().includes(field.toLowerCase()))
const validateField = (field: string) => { const fieldErrors = getFieldErrors(field); errors.value = fieldErrors.length > 0 ? fieldErrors : errors.value.filter(err => !err.toLowerCase().includes(field.toLowerCase())) }
const isStepValid = computed(() => true)
defineExpose({ isStepValid })
</script>
<style scoped>.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }.form-group { display: flex; flex-direction: column; }.form-label { font-size: 0.9375rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }.form-input { padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem; transition: all 0.2s ease; }.form-input:focus { outline: none; border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); }.checkbox-group { display: flex; align-items: center; gap: 0.75rem; }.form-checkbox { width: 20px; height: 20px; cursor: pointer; accent-color: #1e3a8a; }.checkbox-label { cursor: pointer; font-size: 0.9375rem; color: #374151; margin: 0; }.input-with-suffix { position: relative; display: flex; align-items: center; }.input-with-suffix .form-input { flex: 1; padding-right: 2.5rem; }.suffix { position: absolute; right: 0.75rem; color: #9ca3af; font-weight: 500; pointer-events: none; }.info-box { display: flex; gap: 1rem; padding: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; margin-top: 2rem; }.info-icon { font-size: 1.25rem; flex-shrink: 0; }.info-text { margin: 0; font-size: 0.9375rem; color: #1e40af; line-height: 1.5; }@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; gap: 1rem; } }</style>
