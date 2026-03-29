<template>
  <div class="profile-page-wrapper">
    <AppHeader />
    
    <AppContainer class="profile-main-content">
      <div class="profile-container">
        <div class="page-header">
          <div class="esg-badge">ESG</div>
          <p class="page-eyebrow">Account Settings</p>
          <h1 class="profile-title">My Profile</h1>
          <p class="page-subtitle">Keep your company information up to date for accurate ESG reporting.</p>
        </div>

        <!-- Alert Messages -->
        <AppAlert
          v-if="successMessage"
          type="success"
          :message="successMessage"
          @close="successMessage = ''"
        />

        <AppAlert
          v-if="errorMessage"
          type="error"
          :message="errorMessage"
          @close="errorMessage = ''"
        />

        <!-- Profile Form -->
        <div class="form-card">
          <form @submit.prevent="submitForm">

            <!-- Company Information -->
            <div class="section-heading">
              <span class="section-dot"></span>Company Information
            </div>
            <div class="form-grid">
              <div class="form-group">
                <label for="name" class="form-label required">Company Name</label>
                <input
                  id="name"
                  v-model="formData.name"
                  type="text"
                  placeholder="Enter company name"
                  :aria-invalid="!!errors.name"
                  :aria-describedby="errors.name ? 'name-error' : undefined"
                  class="form-input"
                />
                <div v-if="errors.name" :id="`name-error`" role="alert" class="form-error">
                  {{ errors.name }}
                </div>
              </div>
              <div class="form-group">
                <label for="legal_form_id" class="form-label">Legal Form</label>
                <select
                  id="legal_form_id"
                  v-model.number="formData.legal_form_id"
                  :aria-invalid="!!errors.legal_form_id"
                  :aria-describedby="errors.legal_form_id ? 'legal_form_id-error' : undefined"
                  class="form-input form-select"
                >
                  <option value="">Select legal form</option>
                  <option v-for="item in dropdowns.legalForms" :key="item.id" :value="item.id">
                    {{ item.name }}
                  </option>
                </select>
                <div v-if="errors.legal_form_id" :id="`legal_form_id-error`" role="alert" class="form-error">
                  {{ errors.legal_form_id }}
                </div>
              </div>
              <div class="form-group">
                <label for="country_id" class="form-label">Country</label>
                <select
                  id="country_id"
                  v-model.number="formData.country_id"
                  :aria-invalid="!!errors.country_id"
                  :aria-describedby="errors.country_id ? 'country_id-error' : undefined"
                  class="form-input form-select"
                >
                  <option value="">Select country</option>
                  <option v-for="item in dropdowns.countries" :key="item.id" :value="item.id">
                    {{ item.name }}
                  </option>
                </select>
                <div v-if="errors.country_id" :id="`country_id-error`" role="alert" class="form-error">
                  {{ errors.country_id }}
                </div>
              </div>
              <div class="form-group">
                <label for="sector_id" class="form-label">Sector</label>
                <select
                  id="sector_id"
                  v-model.number="formData.sector_id"
                  :aria-invalid="!!errors.sector_id"
                  :aria-describedby="errors.sector_id ? 'sector_id-error' : undefined"
                  class="form-input form-select"
                >
                  <option value="">Select sector</option>
                  <option v-for="item in dropdowns.sectors" :key="item.id" :value="item.id">
                    {{ item.name }}
                  </option>
                </select>
                <div v-if="errors.sector_id" :id="`sector_id-error`" role="alert" class="form-error">
                  {{ errors.sector_id }}
                </div>
              </div>
            </div>

            <!-- Financials & Scale -->
            <div class="section-heading">
              <span class="section-dot"></span>Financials &amp; Scale
            </div>
            <div class="form-grid">
              <div class="form-group">
                <label for="annual_revenue" class="form-label">Annual Revenue</label>
                <input
                  id="annual_revenue"
                  v-model.number="formData.annual_revenue"
                  type="number"
                  placeholder="e.g. 1 500 000"
                  step="0.01"
                  :aria-invalid="!!errors.annual_revenue"
                  :aria-describedby="errors.annual_revenue ? 'annual_revenue-error' : undefined"
                  class="form-input"
                />
                <div v-if="errors.annual_revenue" :id="`annual_revenue-error`" role="alert" class="form-error">
                  {{ errors.annual_revenue }}
                </div>
              </div>
              <div class="form-group">
                <label for="number_of_employees" class="form-label">Number of Employees</label>
                <input
                  id="number_of_employees"
                  v-model.number="formData.number_of_employees"
                  type="number"
                  placeholder="e.g. 250"
                  min="0"
                  :aria-invalid="!!errors.number_of_employees"
                  :aria-describedby="errors.number_of_employees ? 'number_of_employees-error' : undefined"
                  class="form-input"
                />
                <div v-if="errors.number_of_employees" :id="`number_of_employees-error`" role="alert" class="form-error">
                  {{ errors.number_of_employees }}
                </div>
              </div>
              <div class="form-group">
                <label for="number_of_locations" class="form-label">Number of Locations</label>
                <input
                  id="number_of_locations"
                  v-model.number="formData.number_of_locations"
                  type="number"
                  placeholder="e.g. 5"
                  min="0"
                  :aria-invalid="!!errors.number_of_locations"
                  :aria-describedby="errors.number_of_locations ? 'number_of_locations-error' : undefined"
                  class="form-input"
                />
                <div v-if="errors.number_of_locations" :id="`number_of_locations-error`" role="alert" class="form-error">
                  {{ errors.number_of_locations }}
                </div>
              </div>
              <div class="form-group">
                <label for="reporting_period" class="form-label">Reporting Period</label>
                <input
                  id="reporting_period"
                  v-model="formData.reporting_period"
                  type="text"
                  placeholder="e.g. 2025-2026"
                  :aria-invalid="!!errors.reporting_period"
                  :aria-describedby="errors.reporting_period ? 'reporting_period-error' : undefined"
                  class="form-input"
                />
                <div v-if="errors.reporting_period" :id="`reporting_period-error`" role="alert" class="form-error">
                  {{ errors.reporting_period }}
                </div>
              </div>
            </div>

            <!-- Corporate Structure -->
            <div class="section-heading">
              <span class="section-dot"></span>Corporate Structure
            </div>
            <div class="form-group">
              <label class="checkbox-row">
                <input
                  v-model="formData.is_subsidiary"
                  type="checkbox"
                  class="checkbox-input"
                />
                <span>This is a subsidiary company</span>
              </label>
            </div>

            <Transition name="slide">
              <div v-if="formData.is_subsidiary" class="form-group conditional-field">
                <label for="parent_company_id" class="form-label">Parent Company</label>
                <select
                  id="parent_company_id"
                  v-model.number="formData.parent_company_id"
                  :aria-invalid="!!errors.parent_company_id"
                  :aria-describedby="errors.parent_company_id ? 'parent_company_id-error' : undefined"
                  class="form-input form-select"
                >
                  <option value="">Select parent company</option>
                </select>
                <div v-if="errors.parent_company_id" :id="`parent_company_id-error`" role="alert" class="form-error">
                  {{ errors.parent_company_id }}
                </div>
              </div>
            </Transition>

            <!-- Form Actions -->
            <div class="form-actions">
              <AppButton
                type="submit"
                variant="flat"
                :disabled="isLoading"
                style="
                  flex: 1;
                  background-color: #10b981;
                  color: white;
                  padding: 0.75rem 2rem;
                  font-weight: 600;
                  border-radius: 8px;
                  border: none;
                  cursor: pointer;
                  transition: all 0.2s ease;
                "
                @mouseenter="$event.target.style.backgroundColor = '#059669'"
                @mouseleave="$event.target.style.backgroundColor = '#10b981'"
              >
                <span v-if="isLoading" class="saving-dot"></span>
                {{ isLoading ? 'Saving...' : 'Save Changes' }}
              </AppButton>
              <NuxtLink to="/reports" style="flex: 1; text-decoration: none;">
                <AppButton
                  type="button"
                  variant="outlined"
                  :disabled="isLoading"
                  style="
                    width: 100%;
                    background-color: white;
                    color: #0f1f5e;
                    padding: 0.75rem 2rem;
                    font-weight: 600;
                    border-radius: 8px;
                    border: 2px solid #0f1f5e;
                    cursor: pointer;
                    transition: all 0.2s ease;
                  "
                  @mouseenter="$event.target.style.backgroundColor = '#f3f4f6'"
                  @mouseleave="$event.target.style.backgroundColor = 'white'"
                >
                  Cancel
                </AppButton>
              </NuxtLink>
            </div>

          </form>
        </div>
      </div>
    </AppContainer>
    
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useReportDropdowns } from '~/composables/useReportDropdowns'

definePageMeta({
  layout: 'auth'
})

const router = useRouter()
const { $api } = useNuxtApp()
const authStore = useAuthStore()
const { dropdowns, fetchAllDropdowns } = useReportDropdowns()

const isLoading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const formData = ref({
  name: '',
  company_name: '',
  legal_form_id: null as number | null,
  country_id: null as number | null,
  sector_id: null as number | null,
  annual_revenue: null as number | null,
  number_of_employees: null as number | null,
  number_of_locations: null as number | null,
  reporting_period: '',
  parent_company_id: null as number | null,
  is_subsidiary: false,
})

const errors = ref<Record<string, string>>({})

/**
 * Load user profile data on component mount
 */
const loadProfileData = async () => {
  try {
    isLoading.value = true
    const response = await $api.get<any>('/api/profile')
    
    // Get the actual user data from response
    const profileData = response.data?.data || response.data
    console.log('Raw response:', response)
    console.log('Profile data loaded:', profileData)
    
    if (profileData) {
      // Ensure all numeric fields are properly converted
      formData.value.name = profileData.name || ''
      formData.value.company_name = profileData.company_name || ''
      formData.value.legal_form_id = profileData.legal_form_id ? parseInt(profileData.legal_form_id) : null
      formData.value.country_id = profileData.country_id ? parseInt(profileData.country_id) : null
      formData.value.sector_id = profileData.sector_id ? parseInt(profileData.sector_id) : null
      formData.value.annual_revenue = profileData.annual_revenue ? parseFloat(profileData.annual_revenue) : null
      formData.value.number_of_employees = profileData.number_of_employees ? parseInt(profileData.number_of_employees) : null
      formData.value.number_of_locations = profileData.number_of_locations ? parseInt(profileData.number_of_locations) : null
      formData.value.reporting_period = profileData.reporting_period || ''
      formData.value.parent_company_id = profileData.parent_company_id ? parseInt(profileData.parent_company_id) : null
      formData.value.is_subsidiary = !!profileData.is_subsidiary
      
      console.log('Form data populated:', formData.value)
    }
  } catch (error) {
    errorMessage.value = 'Failed to load profile. Please try again.'
    console.error('Error loading profile:', error)
  } finally {
    isLoading.value = false
  }
}

/**
 * Submit form to update profile
 */
const submitForm = async () => {
  try {
    isLoading.value = true
    errors.value = {}
    successMessage.value = ''
    errorMessage.value = ''

    const response = await $api.put<{ message: string, data: any }>('/api/profile', formData.value)

    if (response.data?.message) {
      successMessage.value = response.data.message
      
      // Reload profile data to show updated values
      setTimeout(() => {
        loadProfileData()
      }, 500)
    }
  } catch (error: any) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
      errorMessage.value = 'Please correct the errors below'
    } else {
      errorMessage.value = error.response?.data?.message || 'Failed to update profile. Please try again.'
    }
  } finally {
    isLoading.value = false
  }
}

/**
 * Load dropdowns and profile data on mount
 */
onMounted(async () => {
  // Check authentication
  if (!authStore.isLoggedIn) {
    await authStore.checkAuthStatus()
    if (!authStore.isLoggedIn) {
      router.push('/login')
      return
    }
  }
  
  await fetchAllDropdowns()
  await loadProfileData()
})
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap');

/* ── Variables ───────────────────────────────────────────── */
:root {
  --esg-navy:       #11298a;
  --esg-navy-dark:  #0c1e6b;
  --esg-navy-light: #e8ecf8;
  --esg-stripe:     rgba(232, 180, 184, 0.22);
  --esg-border:     #dde3f5;
  --esg-bg:         #f7f8fc;
  --esg-muted:      #6b7280;
  --esg-error:      #e24b4a;
}

/* ── Page wrapper ────────────────────────────────────────── */
.profile-page-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.profile-main-content {
  flex: 1;
}

.profile-container {
  position: relative;
  max-width: 820px;
  margin: 0 auto;
  padding: 2.5rem 0 4rem;
  font-family: 'DM Sans', sans-serif;
}

/* Stripe background (matches homepage) */
.profile-container::before {
  content: '';
  position: fixed;
  inset: 0;
  background-image: repeating-linear-gradient(
    to right,
    var(--esg-stripe) 0px,
    var(--esg-stripe) 1px,
    transparent 1px,
    transparent 40px
  );
  pointer-events: none;
  z-index: 0;
}

/* ── Page header ─────────────────────────────────────────── */
.page-header {
  position: relative;
  z-index: 1;
  text-align: center;
  margin-bottom: 2rem;
}

.esg-badge {
  display: inline-block;
  background: var(--esg-navy);
  color: #fff;
  font-family: 'Sora', sans-serif;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.08em;
  padding: 4px 14px;
  border-radius: 6px;
  margin-bottom: 0.75rem;
}

.page-eyebrow {
  font-family: 'Sora', sans-serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: var(--esg-navy);
  opacity: 0.6;
  margin-bottom: 0.4rem;
}

.profile-title {
  font-family: 'Sora', sans-serif;
  font-size: 2rem;
  font-weight: 700;
  color: var(--esg-navy);
  line-height: 1.2;
  margin-bottom: 0.5rem;
}

.page-subtitle {
  font-size: 14px;
  color: var(--esg-muted);
}

/* ── Form card ───────────────────────────────────────────── */
.form-card {
  position: relative;
  z-index: 1;
  background: #fff;
  border-radius: 14px;
  border: 1px solid var(--esg-border);
  padding: 2rem;
  overflow: hidden;
}

/* Navy top accent bar */
.form-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  background: var(--esg-navy);
}

/* ── Section headings ────────────────────────────────────── */
.section-heading {
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: 'Sora', sans-serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--esg-navy);
  margin: 1.75rem 0 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid var(--esg-navy-light);
}

.section-heading:first-of-type {
  margin-top: 0;
}

.section-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: var(--esg-navy);
  flex-shrink: 0;
}

/* ── Grid ────────────────────────────────────────────────── */
.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem 1.25rem;
}

/* ── Form groups & labels ────────────────────────────────── */
.form-group {
  display: flex;
  flex-direction: column;
  gap: 5px;
  margin-bottom: 0;
}

.form-label {
  font-size: 12px;
  font-weight: 500;
  color: var(--esg-navy);
  letter-spacing: 0.02em;
  display: block;
  margin-bottom: 0.25rem;
}

.form-label.required::after {
  content: " *";
  color: var(--esg-error);
}

/* ── Checkbox row ────────────────────────────────────────── */
.checkbox-row {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  background: var(--esg-navy-light);
  border-radius: 8px;
  border: 1.5px solid var(--esg-border);
  cursor: pointer;
  user-select: none;
  width: 100%;
  margin-top: 0.25rem;
}

.checkbox-input {
  width: 17px;
  height: 17px;
  accent-color: var(--esg-navy);
  cursor: pointer;
  flex-shrink: 0;
}

.checkbox-row span {
  font-size: 13px;
  font-weight: 500;
  color: var(--esg-navy);
}

/* ── Conditional parent field ────────────────────────────── */
.conditional-field {
  margin-top: 1rem;
}

/* ── Slide transition ────────────────────────────────────── */
.slide-enter-active,
.slide-leave-active {
  transition: opacity 0.25s ease, transform 0.25s ease;
}
.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(-6px);
}

/* ── Form actions ────────────────────────────────────────── */
.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid var(--esg-navy-light);
}

.form-actions > * {
  flex: 1;
}

.form-actions a {
  text-decoration: none;
  display: flex;
}

.form-actions a button,
.form-actions button {
  width: 100%;
  padding: 0.75rem 2rem !important;
  font-size: 14px !important;
  min-height: 44px;
  border-radius: 8px !important;
  transition: all 0.2s ease;
}

/* ── Button overrides (applied via class on AppButton) ───── */
:deep(.btn-primary-esg) {
  font-family: 'Sora', sans-serif !important;
  font-weight: 600 !important;
  letter-spacing: 0.03em !important;
  background: var(--esg-navy) !important;
  border: 1px solid var(--esg-navy) !important;
  color: #fff !important;
  cursor: pointer;
}

:deep(.btn-primary-esg:hover:not(:disabled)) {
  background: var(--esg-navy-dark) !important;
  border-color: var(--esg-navy-dark) !important;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(17, 41, 138, 0.2);
}

:deep(.btn-primary-esg:disabled) {
  background: #9ca3af !important;
  border-color: #9ca3af !important;
  cursor: not-allowed;
  opacity: 0.6;
}

:deep(.btn-outline-esg) {
  font-family: 'Sora', sans-serif !important;
  font-weight: 600 !important;
  letter-spacing: 0.03em !important;
  color: var(--esg-navy) !important;
  border: 1px solid var(--esg-navy) !important;
  background: transparent !important;
  cursor: pointer;
}

:deep(.btn-outline-esg:hover:not(:disabled)) {
  background: var(--esg-navy-light) !important;
  border-color: var(--esg-navy) !important;
  transform: translateY(-1px);
}

:deep(.btn-outline-esg:disabled) {
  color: #9ca3af !important;
  border-color: #d1d5db !important;
  cursor: not-allowed;
  opacity: 0.6;
}

/* ── Saving indicator ────────────────────────────────────── */
.saving-dot {
  display: inline-block;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: currentColor;
  animation: blink 1s infinite;
  margin-right: 4px;
}

@keyframes blink {
  0%, 100% { opacity: 1; }
  50%       { opacity: 0.2; }
}

/* ── Form inputs (native HTML) ───────────────────────────── */
.form-input {
  padding: 0.75rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 1rem;
  transition: all 0.2s ease;
  min-height: 44px;
  font-family: inherit;
  width: 100%;
  box-sizing: border-box;
  background-color: #fff;
  color: #1f2937;
}

.form-input::placeholder {
  color: #9ca3af;
}

.form-input:focus {
  outline: none;
  border-color: var(--esg-navy);
  box-shadow: 0 0 0 3px rgba(17, 41, 138, 0.1);
}

.form-input:disabled {
  background-color: #f3f4f6;
  color: #6b7280;
  cursor: not-allowed;
}

.form-input[aria-invalid="true"] {
  border-color: var(--esg-error);
  background-color: rgba(220, 38, 38, 0.02);
}

.form-input[aria-invalid="true"]:focus {
  box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.form-select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%239ca3af'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 0.75rem center;
  background-size: 20px;
  padding-right: 2.5rem;
  cursor: pointer;
}

.form-select option {
  padding: 0.5rem;
  background: white;
  color: #1f2937;
}

/* ── Form error message ──────────────────────────────────── */
.form-error {
  color: var(--esg-error);
  font-size: 0.875rem;
  font-weight: 500;
  margin-top: 0.25rem;
  display: block;
}

/* ── Responsive ──────────────────────────────────────────── */
@media (max-width: 600px) {
  .form-grid {
    grid-template-columns: 1fr;
  }

  .profile-title {
    font-size: 1.5rem;
  }

  .form-card {
    padding: 1.5rem;
  }

  .form-actions {
    flex-direction: column;
    gap: 0.75rem;
  }

  .form-actions > * {
    flex: 1 !important;
    width: 100%;
  }

  .form-actions button,
  .form-actions a {
    width: 100%;
  }

  .form-actions a button {
    width: 100% !important;
  }
}
</style>
