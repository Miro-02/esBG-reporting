<template>
  <v-card v-bind="$attrs" rounded="lg">
    <v-card-title v-if="title" v-bind="titleProps">
      {{ title }}
    </v-card-title>
    <v-card-text v-if="$slots.default">
      <slot />
    </v-card-text>
    <v-card-actions v-if="$slots.actions">
      <slot name="actions" />
    </v-card-actions>
  </v-card>
</template>
<script setup lang="ts">
defineProps<{
  title?: string
  titleProps?: Record<string, any>
}>()
</script>
