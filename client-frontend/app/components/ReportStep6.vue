<template>
  <ReportStepBase title="Cybersecurity" description="Data protection and security practices" :is-loading="saveState.isLoading" :has-errors="errors.length > 0" :error-message="errors[0]">
    <div class="form-grid">
      <div class="form-group"><label for="cybersecurity_framework_exists" class="form-label">Security Framework</label><div class="checkbox-group"><input id="cybersecurity_framework_exists" v-model="formStore.formData.section5.cybersecurity_framework_exists" type="checkbox" class="form-checkbox" @change="validateField('cybersecurity_framework_exists')" /><label for="cybersecurity_framework_exists" class="checkbox-label">Framework in place</label></div></div>
      <div class="form-group"><label for="cybersecurity_training_rate" class="form-label">Security Training Rate (%)</label><div class="input-with-suffix"><input id="cybersecurity_training_rate" v-model.number="formStore.formData.section5.cybersecurity_training_rate" type="number" class="form-input" placeholder="E.g., 90" min="0" max="100" step="0.01" @blur="validateField('cybersecurity_training_rate')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="data_breach_incidents" class="form-label">Data Breaches (Last Year)</label><input id="data_breach_incidents" v-model.number="formStore.formData.section5.data_breach_incidents" type="number" class="form-input" placeholder="Number of breaches" min="0" @blur="validateField('data_breach_incidents')" /></div>
      <div class="form-group"><label for="gdpr_compliant" class="form-label">GDPR Compliant</label><div class="checkbox-group"><input id="gdpr_compliant" v-model="formStore.formData.section5.gdpr_compliant" type="checkbox" class="form-checkbox" @change="validateField('gdpr_compliant')" /><label for="gdpr_compliant" class="checkbox-label">Compliant</label></div></div>
      <div class="form-group"><label for="iso27001_certified" class="form-label">ISO 27001 Certified</label><div class="checkbox-group"><input id="iso27001_certified" v-model="formStore.formData.section5.iso27001_certified" type="checkbox" class="form-checkbox" @change="validateField('iso27001_certified')" /><label for="iso27001_certified" class="checkbox-label">Certified</label></div></div>
      <div class="form-group"><label for="security_audit_frequency" class="form-label">Audit Frequency</label><input id="security_audit_frequency" v-model="formStore.formData.section5.security_audit_frequency" type="text" class="form-input" placeholder="E.g., Quarterly, Annually" maxlength="255" @blur="validateField('security_audit_frequency')" /></div>
      <div class="form-group"><label for="incident_response_plan_exists" class="form-label">Incident Response Plan</label><div class="checkbox-group"><input id="incident_response_plan_exists" v-model="formStore.formData.section5.incident_response_plan_exists" type="checkbox" class="form-checkbox" @change="validateField('incident_response_plan_exists')" /><label for="incident_response_plan_exists" class="checkbox-label">Plan established</label></div></div>
    </div>
    <div class="info-box"><span class="info-icon">ℹ</span><p class="info-text">Detail your cybersecurity and data protection measures</p></div>
  </ReportStepBase>
</template>
<script setup lang="ts">
import { ref, computed } from 'vue' 
import { useReportFormStore } from '~/stores/reportForm'
import { useReportValidation } from '~/composables/useReportValidation'
import ReportStepBase from '~/components/ReportStepBase.vue'
const formStore = useReportFormStore()
const { validateSection5 } = useReportValidation()
const errors = ref<string[]>([])
const saveState = computed(() => formStore.saveStates[6] || { isLoading: false, error: null, success: false })
const getFieldErrors = (field: string): string[] => validateSection5(formStore.formData.section5).filter(error => error.toLowerCase().includes(field.toLowerCase()))
const validateField = (field: string) => { const fieldErrors = getFieldErrors(field); errors.value = fieldErrors.length > 0 ? fieldErrors : errors.value.filter(err => !err.toLowerCase().includes(field.toLowerCase())) }
const isStepValid = computed(() => true)
defineExpose({ isStepValid })
</script>
<style scoped>.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }.form-group { display: flex; flex-direction: column; }.form-label { font-size: 0.9375rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }.form-input { padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem; transition: all 0.2s ease; }.form-input:focus { outline: none; border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); }.checkbox-group { display: flex; align-items: center; gap: 0.75rem; }.form-checkbox { width: 20px; height: 20px; cursor: pointer; accent-color: #1e3a8a; }.checkbox-label { cursor: pointer; font-size: 0.9375rem; color: #374151; margin: 0; }.input-with-suffix { position: relative; display: flex; align-items: center; }.input-with-suffix .form-input { flex: 1; padding-right: 2.5rem; }.suffix { position: absolute; right: 0.75rem; color: #9ca3af; font-weight: 500; pointer-events: none; }.info-box { display: flex; gap: 1rem; padding: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; margin-top: 2rem; }.info-icon { font-size: 1.25rem; flex-shrink: 0; }.info-text { margin: 0; font-size: 0.9375rem; color: #1e40af; line-height: 1.5; }@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; gap: 1rem; } }</style>
