<template>
  <v-btn
    v-bind="$attrs"
    :variant="variant"
    :class="['custom-btn', variant === 'outlined' ? 'btn-primary' : 'btn-secondary']"
    rounded="pill"
  >
    <slot />
  </v-btn>
</template>

<script setup>
defineProps({
  variant: {
    type: String,
    default: 'outlined' // 'outlined' = primary, 'flat' = secondary
  }
})
</script>

<style scoped>
/* Primary button — blue bg, white border, white text */
.btn-primary {
  background-color: #11298a !important;
  border: 2px solid #ffffff !important;
  color: #ffffff !important;
  font-weight: 600;
}

/* Secondary button — light pink bg, dark blue text */
.btn-secondary {
  background-color: #f0e8e3 !important;
  color: #11298a !important;
  font-weight: 700;
}

.custom-btn {
  text-transform: none;
  letter-spacing: 0;
  font-size: 1rem;
  padding: 0 28px;
  height: 48px;
}
</style>