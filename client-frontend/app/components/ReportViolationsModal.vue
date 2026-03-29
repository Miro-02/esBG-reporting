<template>
  <AppDialog
    :model-value="modelValue"
    @update:model-value="$emit('update:modelValue', $event)"
    title="Compliance Violations"
    class="report-violations-modal"
  >
    <div class="violations-content">
      <!-- Header Message -->
      <div class="violation-header mb-6">
        <div class="flex items-start gap-3">
          <div class="text-red-600 text-2xl">⚠️</div>
          <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
              Compliance Violations Found
            </h3>
            <p class="text-sm text-gray-600">
              Your report contains
              <strong>{{ violations.length }} field(s)</strong> that do not meet your
              country's compliance standards. Please address these issues to ensure
              full compliance.
            </p>
          </div>
        </div>
      </div>

      <!-- Violations List -->
      <div class="violations-list space-y-4">
        <div
          v-for="violation in violations"
          :key="violation.fieldName"
          class="violation-item border border-red-200 bg-red-50 rounded-lg p-4"
        >
          <!-- Field Name -->
          <div class="mb-3">
            <h4 class="font-semibold text-gray-900">{{ violation.fieldLabel }}</h4>
            <p class="text-xs text-gray-500">Section {{ violation.section }}</p>
          </div>

          <!-- Current vs Standard -->
          <div class="grid grid-cols-2 gap-4">
            <!-- Current Value -->
            <div class="bg-white rounded p-3 border border-red-100">
              <div class="text-xs text-gray-500 mb-1">Your Current Value</div>
              <div class="font-semibold text-red-600">
                {{ violation.currentValueFormatted }}
              </div>
            </div>

            <!-- Standard Value -->
            <div class="bg-white rounded p-3 border border-green-100">
              <div class="text-xs text-gray-500 mb-1">Standard Requirement</div>
              <div class="font-semibold text-green-600">
                {{ violation.standardValueFormatted }}
              </div>
            </div>
          </div>

          <!-- Status -->
          <div class="mt-3 text-xs text-gray-600">
            <span
              v-if="isLowerIsBetter(violation.fieldName)"
              class="text-red-600"
            >
              ✗ Must be lower than or equal to {{ violation.standardValueFormatted }}
            </span>
            <span v-else class="text-red-600">
              ✗ Must be higher than or equal to {{ violation.standardValueFormatted }}
            </span>
          </div>
        </div>
      </div>

      <!-- Support Message -->
      <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-sm text-gray-700 mb-3">
          <strong>Need Help?</strong> We can connect you with third-party compliance
          experts who specialize in meeting these standards. They can help you develop
          and implement strategies to achieve compliance.
        </p>
        <button
          @click="$emit('contact-support')"
          class="text-sm font-semibold text-blue-600 hover:text-blue-700 underline"
        >
          Contact Third-Party Support
        </button>
      </div>
    </div>
  </AppDialog>
</template>

<script setup lang="ts">
import type { Violation } from '../composables/useReportViolations'

defineProps<{
  modelValue: boolean
  violations: Violation[]
}>()

defineEmits<{
  'update:modelValue': [value: boolean]
  'contact-support': []
}>()

/**
 * Fields where lower values are better (must be <=)
 * All others use >= comparison
 */
function isLowerIsBetter(fieldName: string): boolean {
  const lowerIsBetterFields = [
    'sickness_rate',
    'grid_electricity_percentage',
    'data_breach_incidents',
    'number_of_breaches',
    'customers_affected_by_breaches',
  ]
  return lowerIsBetterFields.includes(fieldName)
}
</script>

<style scoped>
.report-violations-modal {
  --app-dialog-max-width: 600px;
}

.violations-content {
  padding: 0;
}

.violation-header {
  border-bottom: 1px solid #fee2e2;
  padding-bottom: 1.5rem;
}

.violation-item {
  transition: all 0.2s ease;
}

.violation-item:hover {
  border-color: #ef4444;
  background-color: #fef2f2;
}
</style>
