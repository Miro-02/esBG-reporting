<template>
  <v-alert v-bind="$attrs">
    <slot />
  </v-alert>
</template>

<script setup lang="ts">
// Remove $listeners - it doesn't exist in Vue 3
// $attrs now includes both attributes AND event listeners
defineOptions({
  inheritAttrs: false
})
</script>