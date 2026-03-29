<template>
  <div class="select-wrapper">
    <!-- Label - associated with select for accessibility -->
    <label 
      v-if="label" 
      :for="fieldId"
      :class="{ 'label-required': required }"
    >
      {{ label }}
    </label>

    <!-- Select field with ARIA attributes -->
    <v-select 
      :id="fieldId"
      v-bind="$attrs" 
      :model-value="modelValue"
      :aria-label="ariaLabel || label"
      :aria-describedby="errorId || hintId"
      :aria-invalid="error ? 'true' : 'false'"
      :aria-required="required ? 'true' : 'false'"
      :aria-haspopup="'listbox'"
      :error="error"
      rounded="lg" 
      variant="outlined"
      class="focus:ring-2 focus:ring-offset-1 focus:ring-blue-900"
      @update:model-value="$emit('update:modelValue', $event)"
    >
      <slot />
    </v-select>

    <!-- Error message - announced to screen readers -->
    <div 
      v-if="error && errorMessage" 
      :id="errorId"
      role="alert"
      class="error-message"
      aria-live="polite"
    >
      {{ errorMessage }}
    </div>

    <!-- Hint text -->
    <div 
      v-if="hint && !error" 
      :id="hintId"
      class="hint-text"
    >
      {{ hint }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = withDefaults(defineProps<{
  label?: string
  error?: boolean
  errorMessage?: string
  hint?: string
  required?: boolean
  ariaLabel?: string
  modelValue?: any
}>(), {
  error: false,
  required: false
})

const emit = defineEmits<{
  'update:modelValue': [value: any]
}>()

// Generate unique IDs for label and error message association
const fieldId = `select-${Math.random().toString(36).substr(2, 9)}`
const errorId = `${fieldId}-error`
const hintId = `${fieldId}-hint`
</script>

<style scoped>
.select-wrapper {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

/* Label styling */
label {
  display: block;
  font-weight: 500;
  font-size: 0.875rem;
  color: #374151;
  margin-bottom: 0.25rem;
}

/* Required field indicator */
.label-required::after {
  content: " *";
  color: #dc2626;
}

/* Error message styling */
.error-message {
  font-size: 0.875rem;
  color: #dc2626;
  font-weight: 500;
  margin-top: 0.25rem;
}

/* Hint text styling */
.hint-text {
  font-size: 0.8125rem;
  color: #6b7280;
  margin-top: 0.25rem;
}

/* Responsive sizing */
@media (max-width: 768px) {
  label {
    font-size: 0.8125rem;
  }

  .error-message,
  .hint-text {
    font-size: 0.75rem;
  }
}
</style>
