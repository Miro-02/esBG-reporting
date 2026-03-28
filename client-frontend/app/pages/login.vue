<template>
  <AppContainer>
    <AppCard
      title="Login"
      :title-props="{ class: 'text-h4 text-center mb-4' }"
      class="pa-6"
      elevation="2"
    >
      <form @submit.prevent="submit">
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
          autocomplete="current-password"
          class="mb-4"
          variant="outlined"
        />
        <AppAlert v-if="error" type="error" class="mb-4">
          {{ error }}
        </AppAlert>
        <AppButton type="submit" block size="large" color="primary">
          Login
        </AppButton>
      </form>
      <div class="text-center mt-4">
        <AppButton
          variant="text"
          color="primary"
          @click="showForgot = true"
        >
          Forgot your password?
        </AppButton>
      </div>
      <template #actions>
        <v-spacer />
        <span class="text-caption">Don't have an account?</span>
        <NuxtLink
          to="/register"
          class="text-primary text-decoration-none ml-1"
        >
          Register
        </NuxtLink>
      </template>
    </AppCard>

    <!-- Forgot Password Dialog -->
    <AppDialog 
      v-model="showForgot" 
      title="Forgot Password" 
      max-width="400"
    >
      <form @submit.prevent="sendResetLink">
        <AppTextField
          v-model="forgotEmail"
          label="Email"
          type="email"
          autocomplete="email"
          required
          class="mb-4"
          variant="outlined"
        />
        <AppAlert
          v-if="forgotMessage"
          :type="forgotSuccess ? 'success' : 'error'"
          class="mb-4"
        >
          {{ forgotMessage }}
        </AppAlert>
      </form>
      <template #actions>
        <AppButton @click="sendResetLink" color="primary">
          Send Reset Link
        </AppButton>
      </template>
    </AppDialog>
  </AppContainer>
</template>

<script setup lang="ts">
import { ref } from "vue";
import type {
  LoginRequest,
  ApiError,
  ForgotPasswordRequest,
} from "~/types/auth";
import { useAuthStore } from "~/stores/auth";

definePageMeta({
  ssr: false,
});

const router = useRouter();
const email = ref("");
const password = ref("");
const error = ref("");

const showForgot = ref(false);
const forgotEmail = ref("");
const forgotMessage = ref("");
const forgotSuccess = ref(false);

const authStore = useAuthStore();

const submit = async () => {
  error.value = "";
  const loginRequest: LoginRequest = {
    email: email.value,
    password: password.value,
  };
  try {
    const res = await authStore.login(loginRequest);
    localStorage.setItem("token", res.access_token);
    router.push("/");
  } catch (err: any) {
    const apiError = err.response?.data as ApiError;
    error.value = apiError?.message || "Error";
  }
};

const sendResetLink = async () => {
  forgotMessage.value = "";
  forgotSuccess.value = false;
  const payload: ForgotPasswordRequest = { email: forgotEmail.value };
  try {
    const res = await authStore.forgotPassword(payload);
    forgotMessage.value = res.message || "Reset link sent!";
    forgotSuccess.value = true;
  } catch (err: any) {
    forgotMessage.value =
      err.response?.data?.message || "Error sending reset link.";
    forgotSuccess.value = false;
  }
};
</script>