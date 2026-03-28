<template>
  <AppContainer>
    <AppCard 
      title="Reset Password" 
      :title-props="{ class: 'text-h4 text-center mb-4' }"
      class="pa-6" 
      elevation="2"
    >
      <form @submit.prevent="submit">
        <AppTextField 
          v-model="password" 
          label="New Password" 
          type="password"
          class="mb-4"
          variant="outlined"
          required
        />
        <AppTextField 
          v-model="password_confirmation" 
          label="Confirm Password" 
          type="password"
          class="mb-4"
          variant="outlined"
          required
        />
        <AppAlert v-if="error" type="error" class="mb-4">
          {{ error }}
        </AppAlert>
        <AppAlert v-if="success" type="success" class="mb-4">
          {{ success }}
        </AppAlert>
        <AppButton 
          type="submit" 
          block 
          size="large"
          color="primary"
        >
          Reset Password
        </AppButton>
      </form>
    </AppCard>
  </AppContainer>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import type { ResetPasswordRequest } from '~/types/auth'
import { useAuthStore } from '~/stores/auth'

const route = useRoute()
const router = useRouter()
const password = ref('')
const password_confirmation = ref('')
const error = ref('')
const success = ref('')
const authStore = useAuthStore()

const token = route.params.token || route.query.token
const email = route.query.email

const submit = async () => {
  error.value = ''
  success.value = ''
  if (!password.value || !password_confirmation.value) {
    error.value = 'Please fill in all fields.'
    return
  }
  if (password.value !== password_confirmation.value) {
    error.value = 'Passwords do not match.'
    return
  }
  try {
    const payload: ResetPasswordRequest = {
      email: email as string,
      token: token as string,
      password: password.value,
      password_confirmation: password_confirmation.value
    }
    await authStore.resetPassword(token as string, payload)
    success.value = 'Password reset successful! You can now log in.'
    setTimeout(() => router.push('/login'), 2000)
  } catch (err: any) {
    error.value = err.response?.data?.message || 'Error resetting password.'
  }
}
</script>
