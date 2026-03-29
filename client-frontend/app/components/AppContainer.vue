<template>
  <div class="app-container">
    <slot />
  </div>
</template>

<script setup lang="ts">
// Container for responsive layout with max-width and centered alignment
</script>

<style scoped>
.app-container {
  width: 100%;
  max-width: 1280px;
  margin: 0 auto;
  padding: 1.5rem 0.75rem;
}

/* Mobile: Extra small (320px) */
@media (max-width: 640px) {
  .app-container {
    padding: 1rem 0.75rem;
  }
}

/* Tablet and up: Small (640px) and Medium (768px) */
@media (min-width: 768px) {
  .app-container {
    padding: 2rem 2rem;
  }
}

/* Desktop and up: Large devices (1024px+) */
@media (min-width: 1024px) {
  .app-container {
    padding: 2.5rem 3rem;
  }
}

/* Extra large devices (1280px+) */
@media (min-width: 1280px) {
  .app-container {
    padding: 3rem 4rem;
  }
}
</style>