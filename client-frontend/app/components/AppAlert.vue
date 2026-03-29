<template>
  <v-alert 
    v-bind="$attrs"
    :role="role"
    :aria-live="ariaLive"
    :aria-atomic="true"
    rounded="lg"
    class="alert-wrapper"
  >
    <slot />
  </v-alert>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  type?: 'success' | 'error' | 'warning' | 'info'
  role?: 'alert' | 'status'
  ariaLive?: 'polite' | 'assertive'
}>(), {
  type: 'info',
  role: 'alert',
  ariaLive: 'polite'
})

defineOptions({
  inheritAttrs: false
})
</script>

<style scoped>
.alert-wrapper {
  /* Ensure proper contrast for text in alerts */
  padding: 1rem;
  border-radius: 0.5rem;
}

/* Success alert styling */
:deep(.alert-wrapper.bg-success) {
  background-color: #ecfdf5 !important;
  color: #065f46 !important;
  border-left: 4px solid #10b981;
}

/* Error alert styling */
:deep(.alert-wrapper.bg-error) {
  background-color: #fef2f2 !important;
  color: #991b1b !important;
  border-left: 4px solid #ef4444;
}

/* Warning alert styling */
:deep(.alert-wrapper.bg-warning) {
  background-color: #fefce8 !important;
  color: #854d0e !important;
  border-left: 4px solid #f59e0b;
}

/* Info alert styling */
:deep(.alert-wrapper.bg-info) {
  background-color: #eff6ff !important;
  color: #082f49 !important;
  border-left: 4px solid #3b82f6;
}

/* Responsive sizing */
@media (max-width: 768px) {
  .alert-wrapper {
    padding: 0.875rem;
    font-size: 0.9375rem;
  }
}
</style>