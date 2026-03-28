<template>
  <CompanyRegistrationStepOne @next="handleNext" />
</template>

<script setup lang="ts">
import type { CompanyRegistrationStepOnePayload } from '~/components/CompanyRegistrationStepOne.vue'

definePageMeta({
  layout: 'auth',
  ssr: false,
})

const handleNext = (payload: CompanyRegistrationStepOnePayload) => {
  console.log('Registration step completed', payload)
}
</script>