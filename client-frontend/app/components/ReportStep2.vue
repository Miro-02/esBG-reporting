<template>
  <ReportStepBase
    title="Company Profile"
    description="Information about your company"
    :is-loading="saveState.isLoading"
    :has-errors="errors.length > 0"
    :error-message="errors[0]"
  >
    <div class="form-grid">
      <!-- Company Name -->
      <div class="form-group full-width">
        <label for="company_name" class="form-label">Company Name (Optional)</label>
        <input
          id="company_name"
          v-model="formStore.formData.section1.company_name"
          type="text"
          class="form-input"
          placeholder="E.g., Acme Corporation"
          maxlength="255"
          @change="validateField('company_name')"
        />
      </div>

      <!-- Country -->
      <div class="form-group">
        <label for="country_id" class="form-label">Country (Optional)</label>
        <select
          id="country_id"
          v-model.number="formStore.formData.section1.country_id"
          class="form-input"
          :disabled="isLoadingDropdowns"
          @change="validateField('country_id')"
        >
          <option :value="null">{{ isLoadingDropdowns ? 'Loading...' : 'Select a country...' }}</option>
          <option v-for="country in dropdowns.countries" :key="country.id" :value="country.id">
            {{ country.name }}
          </option>
        </select>
      </div>

      <!-- Sector -->
      <div class="form-group">
        <label for="sector_id" class="form-label">Sector (Optional)</label>
        <select
          id="sector_id"
          v-model.number="formStore.formData.section1.sector_id"
          class="form-input"
          :disabled="isLoadingDropdowns"
          @change="validateField('sector_id')"
        >
          <option :value="null">{{ isLoadingDropdowns ? 'Loading...' : 'Select a sector...' }}</option>
          <option v-for="sector in dropdowns.sectors" :key="sector.id" :value="sector.id">
            {{ sector.name }}
          </option>
        </select>
      </div>

      <!-- Legal Form -->
      <div class="form-group">
        <label for="legal_form_id" class="form-label">Legal Form (Optional)</label>
        <select
          id="legal_form_id"
          v-model.number="formStore.formData.section1.legal_form_id"
          class="form-input"
          :disabled="isLoadingDropdowns"
          @change="validateField('legal_form_id')"
        >
          <option :value="null">{{ isLoadingDropdowns ? 'Loading...' : 'Select a legal form...' }}</option>
          <option v-for="form in dropdowns.legalForms" :key="form.id" :value="form.id">
            {{ form.name }}
          </option>
        </select>
      </div>

      <!-- Annual Revenue -->
      <div class="form-group">
        <label for="annual_revenue" class="form-label">Annual Revenue (Optional)</label>
        <input
          id="annual_revenue"
          v-model.number="formStore.formData.section1.annual_revenue"
          type="number"
          class="form-input"
          placeholder="E.g., 1000000"
          step="0.01"
          min="0"
          @blur="validateField('annual_revenue')"
        />
      </div>

      <!-- Number of Employees -->
      <div class="form-group">
        <label for="number_of_employees" class="form-label">Number of Employees (Optional)</label>
        <input
          id="number_of_employees"
          v-model.number="formStore.formData.section1.number_of_employees"
          type="number"
          class="form-input"
          placeholder="E.g., 500"
          min="0"
          @blur="validateField('number_of_employees')"
        />
      </div>

      <!-- Number of Locations -->
      <div class="form-group">
        <label for="number_of_locations" class="form-label">Number of Locations (Optional)</label>
        <input
          id="number_of_locations"
          v-model.number="formStore.formData.section1.number_of_locations"
          type="number"
          class="form-input"
          placeholder="E.g., 15"
          min="0"
          @blur="validateField('number_of_locations')"
        />
      </div>

      <!-- Is Subsidiary -->
      <div class="form-group">
        <label for="is_subsidiary" class="form-label">Is Subsidiary (Optional)</label>
        <div class="checkbox-group">
          <input
            id="is_subsidiary"
            v-model="formStore.formData.section1.is_subsidiary"
            type="checkbox"
            class="form-checkbox"
            @change="validateField('is_subsidiary')"
          />
          <label for="is_subsidiary" class="checkbox-label">
            This company is a subsidiary of a parent company
          </label>
        </div>
      </div>
    </div>

    <!-- Info box -->
    <div class="info-box">
      <span class="info-icon">ℹ</span>
      <p class="info-text">
        Help us understand your organization's structure and scope. This information helps
        tailor the report to your company's needs.
      </p>
    </div>
  </ReportStepBase>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useReportFormStore } from '~/stores/reportForm'
import { useReportValidation } from '~/composables/useReportValidation'
import { useReportDropdowns } from '~/composables/useReportDropdowns'
import ReportStepBase from '~/components/ReportStepBase.vue'

const formStore = useReportFormStore()
const { validateSection1 } = useReportValidation()
const { isLoading: isLoadingDropdowns, error: dropdownsError, dropdowns, fetchAllDropdowns } = useReportDropdowns()
const { $api } = useNuxtApp()

const errors = ref<string[]>([])
const hasAttemptedPrepopulate = ref(false)

onMounted(() => {
  console.log('[ReportStep2] Component mounted')
  console.log('[ReportStep2] Current reportId:', formStore.reportId)
  console.log('[ReportStep2] Current formData.section1:', formStore.formData.section1)
  
  fetchAllDropdowns()
})

/**
 * Load user's company data and prepopulate form fields
 */
const loadUserCompanyData = async () => {
  console.log('[ReportStep2] loadUserCompanyData called')
  console.log('[ReportStep2] hasAttemptedPrepopulate:', hasAttemptedPrepopulate.value)
  console.log('[ReportStep2] reportId:', formStore.reportId)
  
  if (hasAttemptedPrepopulate.value) {
    console.log('[ReportStep2] Already attempted prepopulation, skipping')
    return
  }
  
  hasAttemptedPrepopulate.value = true
  
  try {
    console.log('[ReportStep2] Fetching user profile data...')
    const response = await $api.get<any>('/api/profile')
    
    console.log('[ReportStep2] API Response:', response)
    
    // Extract the actual user data from the response
    const userData = response.data.data || response.data
    
    console.log('[ReportStep2] User data received:', userData)
    
    if (userData) {
      console.log('[ReportStep2] Populating section1 fields...')
      console.log('[ReportStep2] Full userData object:', userData)
      console.log('[ReportStep2] userData.company_name:', userData.company_name)
      console.log('[ReportStep2] userData.country_id:', userData.country_id)
      console.log('[ReportStep2] userData.sector_id:', userData.sector_id)
      console.log('[ReportStep2] userData.legal_form_id:', userData.legal_form_id)
      console.log('[ReportStep2] userData.annual_revenue:', userData.annual_revenue)
      console.log('[ReportStep2] userData.number_of_employees:', userData.number_of_employees)
      console.log('[ReportStep2] userData.number_of_locations:', userData.number_of_locations)
      console.log('[ReportStep2] userData.is_subsidiary:', userData.is_subsidiary)
      
      // Prepopulate all fields - only if they're empty
      if (!formStore.formData.section1.company_name) {
        formStore.formData.section1.company_name = userData.company_name || ''
        console.log('[ReportStep2] Set company_name to:', formStore.formData.section1.company_name)
      }
      
      if (!formStore.formData.section1.country_id) {
        formStore.formData.section1.country_id = userData.country_id || null
        console.log('[ReportStep2] Set country_id to:', formStore.formData.section1.country_id)
      }
      
      if (!formStore.formData.section1.sector_id) {
        formStore.formData.section1.sector_id = userData.sector_id || null
        console.log('[ReportStep2] Set sector_id to:', formStore.formData.section1.sector_id)
      }
      
      if (!formStore.formData.section1.legal_form_id) {
        formStore.formData.section1.legal_form_id = userData.legal_form_id || null
        console.log('[ReportStep2] Set legal_form_id to:', formStore.formData.section1.legal_form_id)
      }
      
      if (!formStore.formData.section1.annual_revenue) {
        formStore.formData.section1.annual_revenue = userData.annual_revenue ? parseFloat(userData.annual_revenue) : null
        console.log('[ReportStep2] Set annual_revenue to:', formStore.formData.section1.annual_revenue)
      }
      
      if (!formStore.formData.section1.number_of_employees) {
        formStore.formData.section1.number_of_employees = userData.number_of_employees || null
        console.log('[ReportStep2] Set number_of_employees to:', formStore.formData.section1.number_of_employees)
      }
      
      if (!formStore.formData.section1.number_of_locations) {
        formStore.formData.section1.number_of_locations = userData.number_of_locations || null
        console.log('[ReportStep2] Set number_of_locations to:', formStore.formData.section1.number_of_locations)
      }
      
      if (formStore.formData.section1.is_subsidiary === undefined || formStore.formData.section1.is_subsidiary === null) {
        formStore.formData.section1.is_subsidiary = userData.is_subsidiary || false
        console.log('[ReportStep2] Set is_subsidiary to:', formStore.formData.section1.is_subsidiary)
      }
      
      console.log('[ReportStep2] Final section1 state:', formStore.formData.section1)
    } else {
      console.log('[ReportStep2] No user data returned')
    }
  } catch (error) {
    console.error('[ReportStep2] Error loading user company data:', error)
  }
}

// Watch for dropdowns loading to complete, then prepopulate
watch(() => isLoadingDropdowns.value, (loading) => {
  console.log('[ReportStep2] Dropdowns loading state changed:', loading)
  if (!loading && !hasAttemptedPrepopulate.value) {
    console.log('[ReportStep2] Dropdowns finished loading, calling prepopulation')
    loadUserCompanyData()
  }
})

const savedErrors = computed(() => {
  return validateSection1(formStore.formData.section1)
})

const saveState = computed(() => {
  return formStore.saveStates[2] || { isLoading: false, error: null, success: false }
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

.form-input.has-error {
  border-color: #ef4444;
  background: #fef2f2;
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
