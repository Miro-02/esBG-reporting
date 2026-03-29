<template>
  <div class="flex w-screen h-screen">
    <!-- Left Column: Blue (50%) -->
    <div
      class="w-1/2 bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 text-white flex flex-col items-center justify-center p-8 lg:p-20"
    >
      <!-- Brand -->
      <div class="w-full max-w-md text-center">
        <div class="absolute top-8 left-8">
          <img src="/logo.svg" alt="ESG" />
        </div>
        <h2 class="text-4xl font-bold mb-4">Welcome Back</h2>
        <p class="text-lg text-gray-200">Sign in to access your ESG reports</p>
      </div>
    </div>

    <!-- Right Column: White with Stripes (50%) -->
    <div
      class="w-1/2 flex flex-col items-center justify-center p-8 lg:p-24 overflow-y-auto login-right-panel relative"
    >

      <div class="w-full max-w-xl">
        <header class="mb-10">
          <h3 class="text-3xl font-bold text-gray-900 mb-2">Login</h3>
          <p class="text-gray-600 text-sm font-medium">
            Enter your credentials to continue
          </p>
        </header>

        <form @submit.prevent="submit" class="space-y-6">
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-800"
              >E-mail</label
            >
            <AppTextField
              v-model="email"
              type="email"
              autocomplete="email"
              placeholder="Enter your e-mail"
              variant="outlined"
              size="small"
            />
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-800"
              >Password</label
            >
            <AppTextField
              v-model="password"
              type="password"
              autocomplete="current-password"
              placeholder="Enter your password"
              variant="outlined"
              size="small"
            />
          </div>

          <AppAlert v-if="error" type="error" class="mt-4">
            {{ error }}
          </AppAlert>

          <button
            type="submit"
            style="background-color: black"
            class="w-full py-3 text-white rounded-full font-semibold hover:bg-gray-800"
          >
            Login
          </button>
        </form>

        <div class="text-center mt-8 space-y-4">
          <button
            @click="showForgot = true"
            class="w-full text-sm text-blue-600 hover:text-blue-700 font-semibold"
          >
            Forgot your password?
          </button>

          <div class="pt-4 border-t border-gray-300">
            <span class="text-sm text-gray-600">Don't have an account?</span>
            <NuxtLink
              to="/register"
              class="text-blue-600 text-sm font-semibold hover:text-blue-700 ml-1"
            >
              Register
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>

    <!-- Forgot Password Dialog -->
    <AppDialog v-model="showForgot" title="Forgot Password" max-width="400">
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
  </div>
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
  layout: "auth",
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
    router.push("/");
  } catch (err: any) {
    const apiError = err.response?.data as ApiError;
    error.value = apiError?.message || "Error";
    console.log("Login error:", err);
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

<style scoped>
.login-right-panel {
  background-color: #faf8f6;
  background-image:
    linear-gradient(45deg, #f5e6e0 25%, transparent 25%),
    linear-gradient(-45deg, #f5e6e0 25%, transparent 25%),
    linear-gradient(45deg, transparent 75%, #f5e6e0 75%),
    linear-gradient(-45deg, transparent 75%, #f5e6e0 75%);
  background-size: 40px 40px;
  background-position:
    0 0,
    0 20px,
    20px -20px,
    -20px 0px;
}
</style>
