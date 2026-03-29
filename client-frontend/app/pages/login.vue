<template>
  <div class="login-container">
    <!-- Left Column: Blue (hidden on mobile) -->
    <div class="login-left-panel">
      <!-- Brand -->
      <div class="left-panel-content">
        <NuxtLink to="/" class="logo-link" aria-label="Home">
          <img src="/logo.svg" alt="ESG Logo" class="logo-img" />
        </NuxtLink>
        <h1 class="welcome-title">Welcome Back</h1>
        <p class="welcome-subtitle">Sign in to access your ESG reports</p>
      </div>
    </div>

    <!-- Right Column: Login Form -->
    <div class="login-right-panel">
      <div class="login-form-wrapper">
        <!-- Skip to form for accessibility -->
        <a href="#login-form" class="sr-only sr-only-focusable">Skip to login form</a>

        <header class="login-header">
          <h2 id="login-title" class="login-page-title">Login</h2>
          <p class="login-subtitle">Enter your credentials to continue</p>
        </header>

        <form 
          id="login-form"
          @submit.prevent="submit"
          class="login-form"
          novalidate
          aria-labelledby="login-title"
        >
          <!-- Email Field -->
          <div class="form-group">
            <label for="email-input" class="form-label required">Email</label>
            <input
              id="email-input"
              v-model="email"
              type="email"
              autocomplete="email"
              required
              aria-required="true"
              aria-describedby="email-error"
              :aria-invalid="emailError ? 'true' : 'false'"
              placeholder="Enter your email"
              class="form-input"
            />
            <div v-if="emailError" id="email-error" role="alert" class="form-error">
              {{ emailError }}
            </div>
          </div>

          <!-- Password Field -->
          <div class="form-group">
            <label for="password-input" class="form-label required">Password</label>
            <input
              id="password-input"
              v-model="password"
              type="password"
              autocomplete="current-password"
              required
              aria-required="true"
              aria-describedby="password-error"
              :aria-invalid="passwordError ? 'true' : 'false'"
              placeholder="Enter your password"
              class="form-input"
            />
            <div v-if="passwordError" id="password-error" role="alert" class="form-error">
              {{ passwordError }}
            </div>
          </div>

          <!-- General Error Alert -->
          <AppAlert v-if="error" type="error" role="alert" aria-live="polite">
            {{ error }}
          </AppAlert>

          <!-- Submit Button -->
          <AppButton
            type="submit"
            variant="flat"
            :disabled="isLoading"
            class="login-button w-full"
            aria-label="Sign in to your account"
          >
            {{ isLoading ? 'Signing in...' : 'Login' }}
          </AppButton>
        </form>

        <!-- Footer Links -->
        <div class="login-footer">
          <button
            type="button"
            @click="showForgot = true"
            class="forgot-link"
            aria-label="Reset password"
          >
            Forgot your password?
          </button>

          <div class="register-prompt">
            <span class="prompt-text">Don't have an account?</span>
            <NuxtLink to="/register" class="register-link">
              Register
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>

    <!-- Forgot Password Dialog -->
    <AppDialog 
      v-model="showForgot" 
      title="Reset Your Password"
      close-label="Close"
      :show-close="true"
    >
      <form @submit.prevent="sendResetLink" class="forgot-form" novalidate>
        <label for="forgot-email" class="form-label required">Email Address</label>
        <input
          id="forgot-email"
          v-model="forgotEmail"
          type="email"
          autocomplete="email"
          required
          aria-required="true"
          aria-describedby="forgot-error"
          placeholder="Enter your email address"
          class="form-input"
        />
        
        <!-- Forgot Password Message -->
        <AppAlert 
          v-if="forgotMessage" 
          :type="forgotSuccess ? 'success' : 'error'"
          role="alert"
          aria-live="polite"
          class="mt-4"
        >
          {{ forgotMessage }}
        </AppAlert>

        <!-- Help Text -->
        <p class="forgot-help-text">
          We'll send you a link to reset your password. Please check your email.
        </p>
      </form>

      <template #actions>
        <AppButton
          type="button"
          @click="sendResetLink"
          variant="flat"
          :disabled="isResetLoading"
        >
          {{ isResetLoading ? 'Sending...' : 'Send Reset Link' }}
        </AppButton>
      </template>
    </AppDialog>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue"
import type {
  LoginRequest,
  ApiError,
  ForgotPasswordRequest,
} from "~/types/auth"
import { useAuthStore } from "~/stores/auth"

definePageMeta({
  layout: "auth",
  ssr: false,
})

const router = useRouter()
const authStore = useAuthStore()

// Form state
const email = ref("")
const password = ref("")
const error = ref("")
const emailError = ref("")
const passwordError = ref("")
const isLoading = ref(false)

// Forgot password state
const showForgot = ref(false)
const forgotEmail = ref("")
const forgotMessage = ref("")
const forgotSuccess = ref(false)
const isResetLoading = ref(false)

/**
 * Validate email format
 */
const validateEmail = (emailValue: string): boolean => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(emailValue)
}

/**
 * Submit login form
 */
const submit = async () => {
  // Clear previous errors
  error.value = ""
  emailError.value = ""
  passwordError.value = ""

  // Client-side validation
  if (!email.value.trim()) {
    emailError.value = "Email is required"
  } else if (!validateEmail(email.value.trim())) {
    emailError.value = "Please enter a valid email address"
  }

  if (!password.value.trim()) {
    passwordError.value = "Password is required"
  }

  if (emailError.value || passwordError.value) {
    return
  }

  isLoading.value = true

  try {
    const loginRequest: LoginRequest = {
      email: email.value.trim(),
      password: password.value,
    }
    
    await authStore.login(loginRequest)
    router.push("/")
  } catch (err: any) {
    const apiError = err.response?.data as ApiError
    error.value = apiError?.message || "Login failed. Please try again."
    console.error("Login error:", err)
  } finally {
    isLoading.value = false
  }
}

/**
 * Send password reset link
 */
const sendResetLink = async () => {
  forgotMessage.value = ""
  forgotSuccess.value = false

  if (!forgotEmail.value.trim()) {
    forgotMessage.value = "Please enter your email address"
    forgotSuccess.value = false
    return
  }

  if (!validateEmail(forgotEmail.value.trim())) {
    forgotMessage.value = "Please enter a valid email address"
    forgotSuccess.value = false
    return
  }

  isResetLoading.value = true

  try {
    const payload: ForgotPasswordRequest = { email: forgotEmail.value.trim() }
    const res = await authStore.forgotPassword(payload)
    forgotMessage.value = res.message || "Reset link sent! Check your email."
    forgotSuccess.value = true
    // Clear the form after success
    setTimeout(() => {
      forgotEmail.value = ""
    }, 1500)
  } catch (err: any) {
    forgotMessage.value =
      err.response?.data?.message || "Error sending reset link. Please try again."
    forgotSuccess.value = false
  } finally {
    isResetLoading.value = false
  }
}
</script>

<style scoped>
/* ───────────────────────────────────────────────────────── */
/* Login Container Layout (Responsive)                        */
/* ───────────────────────────────────────────────────────── */

.login-container {
  display: flex;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
}

/* Mobile: Stack vertically */
@media (max-width: 768px) {
  .login-container {
    flex-direction: column;
  }
}

/* ───────────────────────────────────────────────────────── */
/* Left Panel (Brand) - Hidden on Mobile */
/* ───────────────────────────────────────────────────────── */

.login-left-panel {
  display: none;
}

@media (min-width: 769px) {
  .login-left-panel {
    position: relative;
    display: flex;
    width: 50%;
    background: linear-gradient(135deg, #1e3a8a 0%, #312e81 100%);
    color: white;
    align-items: center;
    justify-content: center;
    padding: 2rem;
  }
}

.left-panel-content {
  text-align: center;
  max-width: 400px;
}

.logo-link {
  position: absolute;
  top: 2rem;
  left: 2rem;
  display: flex;
  align-items: center;
  outline: none;
}

.logo-link:focus-visible {
  border-radius: 0.5rem;
  outline: 2px solid white;
  outline-offset: 2px;
}

.logo-img {
  height: 3rem;
  width: auto;
}

.welcome-title {
  font-size: 2.25rem;
  font-weight: 700;
  margin-bottom: 1rem;
  line-height: 1.2;
}

.welcome-subtitle {
  font-size: 1.125rem;
  color: rgba(255, 255, 255, 0.9);
}

/* ───────────────────────────────────────────────────────── */
/* Right Panel (Form) */
/* ───────────────────────────────────────────────────────── */

.login-right-panel {
  display: flex;
  width: 100%;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
  overflow-y: auto;
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

@media (min-width: 769px) {
  .login-right-panel {
    width: 50%;
    padding: 3rem 2rem;
  }
}

@media (max-width: 768px) {
  .login-right-panel {
    background-color: white;
    background-image: none;
  }
}

.login-form-wrapper {
  width: 100%;
  max-width: 420px;
}

/* ───────────────────────────────────────────────────────── */
/* Form Header */
/* ───────────────────────────────────────────────────────── */

.login-header {
  margin-bottom: 2rem;
}

.login-page-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 0.75rem 0;
}

.login-subtitle {
  font-size: 0.9375rem;
  color: #6b7280;
  margin: 0;
}

/* ───────────────────────────────────────────────────────── */
/* Form Styling */
/* ───────────────────────────────────────────────────────── */

.login-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  font-size: 0.875rem;
  color: #374151;
}

.form-label.required::after {
  content: " *";
  color: #dc2626;
}

.form-input {
  padding: 0.75rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 1rem;
  transition: all 0.2s ease;
  min-height: 44px;
  font-family: inherit;
}

.form-input:focus {
  outline: none;
  border-color: #11298a;
  box-shadow: 0 0 0 3px rgba(17, 41, 138, 0.1);
}

.form-input[aria-invalid="true"] {
  border-color: #dc2626;
  background-color: rgba(220, 38, 38, 0.02);
}

.form-error {
  color: #dc2626;
  font-size: 0.875rem;
  font-weight: 500;
}

/* ───────────────────────────────────────────────────────── */
/* Buttons */
/* ───────────────────────────────────────────────────────── */

.login-button {
  margin-top: 0.5rem;
  min-height: 48px;
  font-weight: 600;
}

.forgot-link {
  background: none;
  border: none;
  color: #2563eb;
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: 0.25rem;
  outline: none;
  transition: all 0.2s ease;
}

.forgot-link:hover {
  color: #1d4ed8;
  text-decoration: underline;
}

.forgot-link:focus-visible {
  outline: 2px solid #11298a;
  outline-offset: 2px;
}

/* ───────────────────────────────────────────────────────── */
/* Footer Links */
/* ───────────────────────────────────────────────────────── */

.login-footer {
  margin-top: 2rem;
  text-align: center;
  border-top: 1px solid #e5e7eb;
  padding-top: 2rem;
}

.register-prompt {
  margin-top: 1rem;
  font-size: 0.875rem;
}

.prompt-text {
  color: #6b7280;
  margin-right: 0.5rem;
}

.register-link {
  color: #2563eb;
  text-decoration: none;
  font-weight: 600;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
  outline: none;
  transition: all 0.2s ease;
}

.register-link:hover {
  color: #1d4ed8;
  text-decoration: underline;
}

.register-link:focus-visible {
  outline: 2px solid #11298a;
  outline-offset: 2px;
}

/* ───────────────────────────────────────────────────────── */
/* Forgot Password Form */
/* ───────────────────────────────────────────────────────── */

.forgot-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.forgot-help-text {
  font-size: 0.8125rem;
  color: #6b7280;
  margin-top: 0.5rem;
  margin-bottom: 1rem;
  line-height: 1.5;
}

/* ───────────────────────────────────────────────────────── */
/* Responsive Adjustments */
/* ───────────────────────────────────────────────────────── */

@media (max-width: 640px) {
  .login-right-panel {
    padding: 1.5rem 1rem;
  }

  .login-form-wrapper {
    max-width: 100%;
  }

  .login-page-title {
    font-size: 1.75rem;
  }

  .welcome-title {
    font-size: 1.875rem;
  }

  .form-input {
    font-size: 16px; /* Prevents zoom on iOS */
  }
}
</style>
