<template>
  <AppDialog
    :model-value="modelValue"
    @update:model-value="$emit('update:modelValue', $event)"
    title="Request Third-Party Compliance Support"
    class="contact-dialog"
  >
    <div class="contact-content">
      <p class="text-sm text-gray-600 mb-4">
        Fill out the form below and we'll connect you with compliance experts who can
        help you address these violations.
      </p>

      <!-- Form -->
      <form @submit.prevent="submitContactForm" class="space-y-4">
        <!-- Name -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Your Name
          </label>
          <input
            v-model="formData.name"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="John Doe"
          />
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Email Address
          </label>
          <input
            v-model="formData.email"
            type="email"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="john@example.com"
          />
        </div>

        <!-- Phone (Optional) -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Phone Number (Optional)
          </label>
          <input
            v-model="formData.phone"
            type="tel"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="+1 (555) 000-0000"
          />
        </div>

        <!-- Message -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Additional Details
          </label>
          <textarea
            v-model="formData.message"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
            placeholder="Tell us more about your compliance needs or specific challenges..."
          />
        </div>

        <!-- Violations Summary -->
        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
          <p class="text-xs font-semibold text-gray-700 mb-2">Violations to Address:</p>
          <ul class="text-xs text-gray-600 space-y-1">
            <li v-for="violation in violations" :key="violation.fieldName" class="flex items-start gap-2">
              <span class="text-red-500 mt-0.5">•</span>
              <span>{{ violation.fieldLabel }} (Section {{ violation.section }})</span>
            </li>
          </ul>
        </div>

        <!-- Error Message -->
        <div v-if="submitError" class="bg-red-50 text-red-700 text-sm p-3 rounded-lg border border-red-200">
          {{ submitError }}
        </div>

        <!-- Success Message -->
        <div v-if="submitSuccess" class="bg-green-50 text-green-700 text-sm p-3 rounded-lg border border-green-200">
          Thank you! We've received your request and will contact you shortly.
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 pt-4">
          <button
            type="button"
            @click="closeDialog"
            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition"
            :disabled="isSubmitting"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="isSubmitting"
          >
            <span v-if="isSubmitting" class="flex items-center gap-2">
              <span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin" />
              Submitting...
            </span>
            <span v-else>Send Request</span>
          </button>
        </div>
      </form>
    </div>
  </AppDialog>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import type { Violation } from '../composables/useReportViolations'

defineProps<{
  modelValue: boolean
  violations: Violation[]
}>()

const emit = defineEmits<{
  'update:modelValue': [value: boolean]
}>()

const isSubmitting = ref(false)
const submitError = ref<string | null>(null)
const submitSuccess = ref(false)

const formData = reactive({
  name: '',
  email: '',
  phone: '',
  message: '',
})

const submitContactForm = async () => {
  isSubmitting.value = true
  submitError.value = null

  try {
    // TODO: Replace with actual API endpoint for submitting support requests
    // For now, we'll simulate a successful submission
    await new Promise((resolve) => setTimeout(resolve, 1000))

    // In production, this would be:
    // const response = await $fetch('/api/compliance-support-requests', {
    //   method: 'POST',
    //   body: {
    //     name: formData.name,
    //     email: formData.email,
    //     phone: formData.phone,
    //     message: formData.message,
    //     violationCount: violations.value.length,
    //   },
    // })

    submitSuccess.value = true
    setTimeout(() => {
      closeDialog()
    }, 2000)
  } catch (error: any) {
    submitError.value = error.message || 'Failed to submit support request'
  } finally {
    isSubmitting.value = false
  }
}

const closeDialog = () => {
  // Reset form
  formData.name = ''
  formData.email = ''
  formData.phone = ''
  formData.message = ''
  submitError.value = null
  submitSuccess.value = false

  // Close dialog
  emit('update:modelValue', false)
}
</script>

<style scoped>
.contact-dialog {
  --app-dialog-max-width: 500px;
}

.contact-content {
  padding: 0;
}
</style>
