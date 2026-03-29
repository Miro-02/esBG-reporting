<template>
  <ReportStepBase
    title="Frameworks & Certifications"
    description="Select relevant frameworks and certifications"
    :is-loading="saveState.isLoading"
  >
    <div class="framework-grid">
      <div class="framework-section">
        <h3>Frameworks</h3>
        <p class="section-description">Select all frameworks that apply to your organization</p>
        <div v-if="isLoadingDropdowns" class="loading-text">Loading frameworks...</div>
        <div v-else-if="dropdowns.frameworks.length === 0" class="empty-text">No frameworks available</div>
        <div v-else class="checkbox-list">
          <div v-for="framework in dropdowns.frameworks" :key="framework.id" class="checkbox-item">
            <input
              :id="`frame_${framework.id}`"
              type="checkbox"
              :checked="isFrameworkSelected(framework.id)"
              class="form-checkbox"
              @change="toggleFramework(framework.id)"
            />
            <label :for="`frame_${framework.id}`" class="checkbox-label">{{ framework.name }}</label>
          </div>
        </div>
      </div>

      <div class="framework-section">
        <h3>Certifications</h3>
        <p class="section-description">Select all certifications your organization holds</p>
        <div v-if="isLoadingDropdowns" class="loading-text">Loading certifications...</div>
        <div v-else-if="dropdowns.certifications.length === 0" class="empty-text">No certifications available</div>
        <div v-else class="checkbox-list">
          <div v-for="certification in dropdowns.certifications" :key="certification.id" class="checkbox-item">
            <input
              :id="`cert_${certification.id}`"
              type="checkbox"
              :checked="isCertificationSelected(certification.id)"
              class="form-checkbox"
              @change="toggleCertification(certification.id)"
            />
            <label :for="`cert_${certification.id}`" class="checkbox-label">{{ certification.name }}</label>
          </div>
        </div>
      </div>
    </div>
  </ReportStepBase>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { useReportFormStore } from '~/stores/reportForm'
import { useReportDropdowns } from '~/composables/useReportDropdowns'
import ReportStepBase from '~/components/ReportStepBase.vue'

const formStore = useReportFormStore()
const { isLoading: isLoadingDropdowns, dropdowns, fetchAllDropdowns } = useReportDropdowns()

onMounted(() => {
  fetchAllDropdowns()
})

const saveState = computed(() => {
  return formStore.saveStates[9] || { isLoading: false, error: null, success: false }
})

const isStepValid = computed(() => true)

const isFrameworkSelected = (frameworkId: number): boolean => {
  return formStore.formData.frameworks_certifications.frameworks.includes(frameworkId)
}

const isCertificationSelected = (certificationId: number): boolean => {
  return formStore.formData.frameworks_certifications.certifications.includes(certificationId)
}

const toggleFramework = (frameworkId: number) => {
  const frameworks = formStore.formData.frameworks_certifications.frameworks
  const index = frameworks.indexOf(frameworkId)
  if (index > -1) {
    frameworks.splice(index, 1)
  }
  else {
    frameworks.push(frameworkId)
  }
}

const toggleCertification = (certificationId: number) => {
  const certifications = formStore.formData.frameworks_certifications.certifications
  const index = certifications.indexOf(certificationId)
  if (index > -1) {
    certifications.splice(index, 1)
  }
  else {
    certifications.push(certificationId)
  }
}

defineExpose({ isStepValid })
</script>

<style scoped>
.framework-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.framework-section h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
}

.section-description {
  margin: 0 0 1rem 0;
  font-size: 0.875rem;
  color: #6b7280;
}

.checkbox-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.checkbox-item {
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

.loading-text {
  font-size: 0.9375rem;
  color: #6b7280;
  font-style: italic;
}

.empty-text {
  font-size: 0.9375rem;
  color: #9ca3af;
}

@media (max-width: 768px) {
  .framework-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
}
</style>
