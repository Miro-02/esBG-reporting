<template>
  <div class="report-step">
    <!-- Step header -->
    <div class="step-header">
      <h1 class="step-heading">{{ title }}</h1>
      <p class="step-description">{{ description }}</p>
    </div>

    <!-- Error message (if any) -->
    <div v-if="hasErrors && errorMessage" class="error-alert">
      <span class="error-icon">⚠</span>
      <p class="error-text">{{ errorMessage }}</p>
    </div>

    <!-- Step form content -->
    <div class="step-form">
      <slot />
    </div>

    <!-- Loading overlay -->
    <Transition name="fade">
      <div v-if="isLoading" class="loading-overlay">
        <div class="loading-content">
          <div class="spinner" />
          <p>Saving your progress...</p>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup lang="ts">
interface Props {
  title: string
  description: string
  isLoading?: boolean
  hasErrors?: boolean
  errorMessage?: string | null
}

withDefaults(defineProps<Props>(), {
  isLoading: false,
  hasErrors: false,
  errorMessage: null,
})
</script>

<style scoped>
.report-step {
  position: relative;
  animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Header */
/* ────────────────────────────────────────────────────────────────────────── */

.step-header {
  margin-bottom: 2rem;
  padding-bottom: 1.5rem;
  border-bottom: 1px solid #e2e8f0;
}

.step-heading {
  margin: 0 0 0.5rem 0;
  font-size: 1.875rem;
  font-weight: 700;
  color: #1f2937;
  line-height: 1.2;
}

.step-description {
  margin: 0;
  font-size: 1rem;
  color: #6b7280;
  line-height: 1.5;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Error Alert */
/* ────────────────────────────────────────────────────────────────────────── */

.error-alert {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  margin-bottom: 1.5rem;
  background: #fee2e2;
  border: 1px solid #fecaca;
  border-radius: 0.5rem;
  animation: slideIn 0.2s ease-out;
}

.error-icon {
  font-size: 1.25rem;
  flex-shrink: 0;
  margin-top: 0.125rem;
}

.error-text {
  margin: 0;
  font-size: 0.9375rem;
  color: #dc2626;
  line-height: 1.5;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Form */
/* ────────────────────────────────────────────────────────────────────────── */

.step-form {
  padding: 1rem 0;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Loading Overlay */
/* ────────────────────────────────────────────────────────────────────────── */

.loading-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 0.5rem;
  backdrop-filter: blur(2px);
  z-index: 10;
}

.loading-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #e5e7eb;
  border-top-color: #1e3a8a;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.loading-overlay p {
  font-size: 0.9375rem;
  color: #6b7280;
  font-weight: 500;
  margin: 0;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Transitions */
/* ────────────────────────────────────────────────────────────────────────── */

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* ────────────────────────────────────────────────────────────────────────── */
/* Responsive */
/* ────────────────────────────────────────────────────────────────────────── */

@media (max-width: 768px) {
  .step-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
  }

  .step-heading {
    font-size: 1.5rem;
  }

  .step-description {
    font-size: 0.9375rem;
  }
}
</style>
