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
  padding: 1.25rem 1.5rem;
  border-radius: 0.75rem;
  font-weight: 500;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  border-left: 4px solid;
}

/* Success alert styling */
:deep(.alert-wrapper.bg-success) {
  background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important;
  color: #065f46 !important;
  border-left-color: #10b981 !important;
}

/* Error alert styling */
:deep(.alert-wrapper.bg-error) {
  background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%) !important;
  color: #991b1b !important;
  border-left-color: #ef4444 !important;
}

/* Warning alert styling */
:deep(.alert-wrapper.bg-warning) {
  background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%) !important;
  color: #854d0e !important;
  border-left-color: #f59e0b !important;
}

/* Info alert styling */
:deep(.alert-wrapper.bg-info) {
  background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
  color: #082f49 !important;
  border-left-color: #3b82f6 !important;
}

/* Responsive sizing */
@media (max-width: 768px) {
  .alert-wrapper {
    padding: 0.875rem;
    font-size: 0.9375rem;
  }
}
</style>