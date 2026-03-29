<template>
  <article
    role="article"
    class="card-wrapper"
    v-bind="$attrs"
  >
    <v-card rounded="lg">
      <!-- Card title/heading -->
      <v-card-title 
        v-if="title" 
        :id="headingId"
        as="h2"
        v-bind="titleProps"
        class="card-title"
      >
        {{ title }}
      </v-card-title>

      <!-- Card content -->
      <v-card-text v-if="$slots.default" class="card-content">
        <slot />
      </v-card-text>

      <!-- Card actions -->
      <v-card-actions v-if="$slots.actions" class="card-actions">
        <slot name="actions" />
      </v-card-actions>
    </v-card>
  </article>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  title?: string
  titleProps?: Record<string, any>
}>(), {})

// Generate unique ID for heading
const headingId = `card-heading-${Math.random().toString(36).substr(2, 9)}`
</script>

<style scoped>
.card-wrapper {
  display: flex;
  flex-direction: column;
}

.card-title {
  font-size: 1.125rem;
  font-weight: 600;
}

@media (max-width: 768px) {
  .card-title {
    font-size: 1rem;
  }
}

.card-content {
  padding: 1rem;
  line-height: 1.6;
}

.card-actions {
  padding: 1rem;
  gap: 0.5rem;
}

/* Ensure card is properly keyboard accessible */
:deep(.v-card) {
  outline: none;
  transition: all 0.2s ease;
}

:deep(.v-card:focus-visible) {
  outline: 2px solid #11298a;
  outline-offset: 2px;
}
</style>
