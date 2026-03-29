<template>
  <ReportStepBase title="Supply Chain" description="Ethical sourcing and supplier management" :is-loading="saveState.isLoading" :has-errors="errors.length > 0" :error-message="errors[0]">
    <div class="form-grid">
      <div class="form-group"><label for="supplier_code_of_conduct_exists" class="form-label">Supplier Code of Conduct</label><div class="checkbox-group"><input id="supplier_code_of_conduct_exists" v-model="formStore.formData.section6.supplier_code_of_conduct_exists" type="checkbox" class="form-checkbox" @change="validateField('supplier_code_of_conduct_exists')" /><label for="supplier_code_of_conduct_exists" class="checkbox-label">Code established</label></div></div>
      <div class="form-group"><label for="supplier_audit_rate" class="form-label">Supplier Audit Rate (%)</label><div class="input-with-suffix"><input id="supplier_audit_rate" v-model.number="formStore.formData.section6.supplier_audit_rate" type="number" class="form-input" placeholder="E.g., 80" min="0" max="100" step="0.01" @blur="validateField('supplier_audit_rate')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="ethical_sourcing_percentage" class="form-label">Ethical Sourcing (%)</label><div class="input-with-suffix"><input id="ethical_sourcing_percentage" v-model.number="formStore.formData.section6.ethical_sourcing_percentage" type="number" class="form-input" placeholder="E.g., 75" min="0" max="100" step="0.01" @blur="validateField('ethical_sourcing_percentage')" /><span class="suffix">%</span></div></div>
      <div class="form-group"><label for="conflict_minerals_assessment_exists" class="form-label">Conflict Minerals Assessment</label><div class="checkbox-group"><input id="conflict_minerals_assessment_exists" v-model="formStore.formData.section6.conflict_minerals_assessment_exists" type="checkbox" class="form-checkbox" @change="validateField('conflict_minerals_assessment_exists')" /><label for="conflict_minerals_assessment_exists" class="checkbox-label">Assessment done</label></div></div>
      <div class="form-group"><label for="supply_chain_risk_assessment_exists" class="form-label">Risk Assessment</label><div class="checkbox-group"><input id="supply_chain_risk_assessment_exists" v-model="formStore.formData.section6.supply_chain_risk_assessment_exists" type="checkbox" class="form-checkbox" @change="validateField('supply_chain_risk_assessment_exists')" /><label for="supply_chain_risk_assessment_exists" class="checkbox-label">Assessment done</label></div></div>
      <div class="form-group"><label for="supplier_diversity_percentage" class="form-label">Supplier Diversity (%)</label><div class="input-with-suffix"><input id="supplier_diversity_percentage" v-model.number="formStore.formData.section6.supplier_diversity_percentage" type="number" class="form-input" placeholder="E.g., 30" min="0" max="100" step="0.01" @blur="validateField('supplier_diversity_percentage')" /><span class="suffix">%</span></div></div>
    </div>
    <div class="info-box"><span class="info-icon">ℹ</span><p class="info-text">Document your supply chain practices and supplier governance</p></div>
  </ReportStepBase>
</template>
<script setup lang="ts">
import { ref, computed } from 'vue'
import { useReportFormStore } from '~/stores/reportForm'
import { useReportValidation } from '~/composables/useReportValidation'
import ReportStepBase from '~/components/ReportStepBase.vue'
const formStore = useReportFormStore()
const { validateSection6 } = useReportValidation()
const errors = ref<string[]>([])
const saveState = computed(() => formStore.saveStates[7] || { isLoading: false, error: null, success: false })
const getFieldErrors = (field: string): string[] => validateSection6(formStore.formData.section6).filter(error => error.toLowerCase().includes(field.toLowerCase()))
const validateField = (field: string) => { const fieldErrors = getFieldErrors(field); errors.value = fieldErrors.length > 0 ? fieldErrors : errors.value.filter(err => !err.toLowerCase().includes(field.toLowerCase())) }
const isStepValid = computed(() => true)
defineExpose({ isStepValid })
</script>
<style scoped>.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }.form-group { display: flex; flex-direction: column; }.form-label { font-size: 0.9375rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }.form-input { padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem; transition: all 0.2s ease; }.form-input:focus { outline: none; border-color: #1e3a8a; box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1); }.checkbox-group { display: flex; align-items: center; gap: 0.75rem; }.form-checkbox { width: 20px; height: 20px; cursor: pointer; accent-color: #1e3a8a; }.checkbox-label { cursor: pointer; font-size: 0.9375rem; color: #374151; margin: 0; }.input-with-suffix { position: relative; display: flex; align-items: center; }.input-with-suffix .form-input { flex: 1; padding-right: 2.5rem; }.suffix { position: absolute; right: 0.75rem; color: #9ca3af; font-weight: 500; pointer-events: none; }.info-box { display: flex; gap: 1rem; padding: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; margin-top: 2rem; }.info-icon { font-size: 1.25rem; flex-shrink: 0; }.info-text { margin: 0; font-size: 0.9375rem; color: #1e40af; line-height: 1.5; }@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; gap: 1rem; } }</style>
