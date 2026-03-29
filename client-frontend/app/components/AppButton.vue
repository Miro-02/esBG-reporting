<template>
  <v-btn
    v-bind="$attrs"
    :variant="variant"
    :type="type"
    :disabled="disabled"
    :aria-disabled="disabled"
    :class="[
      'custom-btn',
      variant === 'outlined' ? 'btn-primary' : 'btn-secondary',
      disabled && 'btn-disabled',
      'focus:ring-2 focus:ring-offset-2 focus:ring-blue-900'
    ]"
    rounded="pill"
    @keydown="handleKeydown"
  >
    <slot />
  </v-btn>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = withDefaults(defineProps<{
  variant?: 'outlined' | 'flat' | 'text'
  type?: 'button' | 'submit' | 'reset'
  disabled?: boolean
}>(), {
  variant: 'outlined',
  type: 'button',
  disabled: false
})

/**
 * Handle keyboard activation (Space key)
 * Vuetify handles Enter, but we ensure Space also works
 */
const handleKeydown = (event: KeyboardEvent) => {
  if (event.key === ' ' && !props.disabled) {
    event.preventDefault()
    ;(event.target as HTMLButtonElement)?.click()
  }
}

/**
 * Compute aria-disabled for custom buttons without native disabled support
 */
const ariaDisabled = computed(() => props.disabled ? 'true' : 'false')
</script>

<style scoped>
/* Primary button — blue bg, white border, white text */
.btn-primary {
  background-color: #11298a !important;
  border: 2px solid #ffffff !important;
  color: #ffffff !important;
  font-weight: 600;
  transition: all 0.2s ease;
}

.btn-primary:hover:not(:disabled) {
  background-color: #0d1b5e !important;
  transform: translateY(-2px);
}

.btn-primary:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(17, 41, 138, 0.1), inset 0 0 0 2px #11298a;
}

/* Secondary button — light pink bg, dark blue text */
.btn-secondary {
  background-color: #f0e8e3 !important;
  color: #11298a !important;
  font-weight: 700;
  transition: all 0.2s ease;
}

.btn-secondary:hover:not(:disabled) {
  background-color: #e8ddd4 !important;
  transform: translateY(-2px);
}

.btn-secondary:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px rgba(17, 41, 138, 0.1), inset 0 0 0 2px #11298a;
}

/* Disabled state */
.btn-disabled {
  opacity: 0.6 !important;
  cursor: not-allowed !important;
  pointer-events: none !important;
}

.custom-btn {
  text-transform: none;
  letter-spacing: 0;
  font-size: 1rem;
  padding: 0 28px;
  height: 48px;
  min-height: 44px; /* Touch target minimum for accessibility */
  min-width: 44px;
  border-radius: 999px;
}

/* Responsive text size */
@media (max-width: 768px) {
  .custom-btn {
    font-size: 0.9375rem;
    padding: 0 20px;
    height: 44px;
  }
}
</style>