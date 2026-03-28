<template>
  <AppContainer>
    <AppCard 
      title="Register" 
      :title-props="{ class: 'text-h4 text-center mb-4' }"
      class="pa-6" 
      elevation="2"
    >
      <form @submit.prevent="submit">
        <AppTextField 
          v-model="name" 
          label="Name"
          autocomplete="name"
          class="mb-4"
          variant="outlined"
        />
        <AppTextField 
          v-model="email" 
          label="Email" 
          type="email"
          autocomplete="email"
          class="mb-4"
          variant="outlined"
        />
        <AppTextField 
          v-model="password" 
          label="Password" 
          type="password"
          autocomplete="new-password"
          class="mb-4"
          variant="outlined"
        />
        <AppTextField 
          v-model="password_confirmation" 
          label="Confirm Password" 
          type="password"
          autocomplete="new-password"
          class="mb-4"
          variant="outlined"
        />
        <AppAlert v-if="error" type="error" class="mb-4">
          {{ error }}
        </AppAlert>
        <AppButton 
          type="submit" 
          block 
          size="large"
          color="primary"
        >
          Register
        </AppButton>
      </form>
      <template #actions>
        <v-spacer />
        <span class="text-caption">Already have an account?</span>
        <NuxtLink to="/login" class="text-primary text-decoration-none ml-1">
          Login
        </NuxtLink>
      </template>
    </AppCard>
  </AppContainer>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { RegisterRequest, ApiError } from '~/types/auth'
import { useAuthStore } from '~/stores/auth'

definePageMeta({
  ssr: false,
});

const router = useRouter()
const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const error = ref('')

const authStore = useAuthStore()

const submit = async () => {
  error.value = ''
  
  const registerRequest: RegisterRequest = {
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value
  }
  
  try {
    await authStore.register(registerRequest)
    router.push('/login')
  } catch (err: any) {
    const apiError = err.response?.data as ApiError
    error.value = apiError?.message || 'Error'
    console.log(err);
    
  }
}
</script>