<template>
  <div class="register-container">
    <!-- Left Column: Brand (hidden on mobile) -->
    <div class="register-left-panel">
      <div class="left-panel-content">
        <NuxtLink to="/" class="logo-link" aria-label="Home">
          <img src="/logo.svg" alt="ESG Logo" class="logo-img" />
        </NuxtLink>
        <h1 class="brand-title">Create Your Account</h1>
        <p class="brand-subtitle">Use 3 simple steps to get started</p>

        <!-- Progress Indicator -->
        <nav class="progress-steps" aria-label="Registration progress">
          <div 
            v-for="(step, index) in steps" 
            :key="index"
            class="progress-step"
            :aria-current="currentStep === index ? 'step' : undefined"
          >
            <div class="step-indicator" :class="getStepClass(index)">
              <span v-if="currentStep > index" aria-hidden="true">✓</span>
              <span v-else>{{ index + 1 }}</span>
            </div>
            <span class="step-label">{{ step }}</span>
          </div>
        </nav>
      </div>
    </div>

    <!-- Right Column: Form -->
    <div class="register-right-panel">
      <!-- Success Message -->
      <transition name="fade">
        <div v-if="showSuccess" class="success-container">
          <div class="success-content">
            <h2 class="success-title">Registration Successful!</h2>
            <p class="success-message">
              Your information has been sent successfully. Our team will verify your account within 24 hours. 
              An email will be sent when your account is ready.
            </p>
            <AppButton 
              @click="goHome" 
              variant="flat"
              class="mt-8"
            >
              Return to Home
            </AppButton>
          </div>
        </div>
      </transition>

      <!-- Form Content -->
      <form v-if="!showSuccess" class="register-form-wrapper" novalidate>
        <!-- Step 1: Personal Information -->
        <section v-if="currentStep === 0" class="form-step">
          <header class="step-header">
            <h2 id="step-1-title" class="step-title">Personal Information</h2>
            <p class="step-subtitle">Step 1 of 3</p>
          </header>

          <!-- Company Name -->
          <div class="form-group">
            <label for="company-name" class="form-label required">Company Name</label>
            <input
              id="company-name"
              v-model="name"
              type="text"
              autocomplete="organization"
              required
              aria-required="true"
              aria-describedby="name-error"
              :aria-invalid="nameError ? 'true' : 'false'"
              placeholder="Enter your company name"
              class="form-input"
            />
            <div v-if="nameError" id="name-error" role="alert" class="form-error">
              {{ nameError }}
            </div>
          </div>

          <!-- Email -->
          <div class="form-group">
            <label for="register-email" class="form-label required">Email Address</label>
            <input
              id="register-email"
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

          <!-- Phone -->
          <div class="form-group">
            <label for="register-phone" class="form-label required">Phone Number</label>
            <input
              id="register-phone"
              v-model="phone"
              type="tel"
              autocomplete="tel"
              required
              aria-required="true"
              aria-describedby="phone-error"
              :aria-invalid="phoneError ? 'true' : 'false'"
              placeholder="Enter your phone number"
              class="form-input"
            />
            <div v-if="phoneError" id="phone-error" role="alert" class="form-error">
              {{ phoneError }}
            </div>
          </div>

          <!-- Password -->
          <div class="form-group">
            <label for="register-password" class="form-label required">Create Password</label>
            <input
              id="register-password"
              v-model="password"
              type="password"
              autocomplete="new-password"
              required
              aria-required="true"
              aria-describedby="password-hint password-error"
              :aria-invalid="passwordError ? 'true' : 'false'"
              placeholder="Minimum 8 characters"
              class="form-input"
            />
            <p id="password-hint" class="form-hint">Must be at least 8 characters</p>
            <div v-if="passwordError" id="password-error" role="alert" class="form-error">
              {{ passwordError }}
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="form-group">
            <label for="confirm-password" class="form-label required">Confirm Password</label>
            <input
              id="confirm-password"
              v-model="password_confirmation"
              type="password"
              autocomplete="new-password"
              required
              aria-required="true"
              aria-describedby="confirm-error"
              :aria-invalid="confirmError ? 'true' : 'false'"
              placeholder="Confirm your password"
              class="form-input"
            />
            <div v-if="confirmError" id="confirm-error" role="alert" class="form-error">
              {{ confirmError }}
            </div>
          </div>

          <!-- Terms Acceptance -->
          <div class="form-group checkbox-group">
            <label for="terms-agreement" class="form-label required">Terms & Conditions</label>
            <div class="checkbox-wrapper">
              <v-checkbox
                id="terms-agreement"
                v-model="agreedToTerms"
                required
                aria-required="true"
                aria-describedby="terms-description"
                :aria-invalid="termsError ? 'true' : 'false'"
                density="compact"
                hide-details
                class="checkbox-minimal"
              >
                <template #label>
                  <span class="checkbox-label">
                    I agree to the
                    <NuxtLink to="/terms-and-conditions" class="link-inline">
                      Terms and Conditions
                    </NuxtLink>
                    and 
                    <NuxtLink to="/" class="link-inline">
                      Privacy Policy
                    </NuxtLink>
                  </span>
                </template>
              </v-checkbox>
            </div>
            <div v-if="termsError" id="terms-description" role="alert" class="form-error">
              {{ termsError }}
            </div>
          </div>

          <!-- Error Alert -->
          <AppAlert v-if="error" type="error" role="alert" aria-live="polite" class="mt-6">
            {{ error }}
          </AppAlert>

          <!-- Navigation -->
          <div class="form-actions">
            <AppButton
              type="button"
              @click="nextStep"
              variant="flat"
              class="w-full"
              aria-label="Proceed to step 2: ID verification"
            >
              Continue to Next Step
            </AppButton>
          </div>

          <!-- Login Link -->
          <div class="form-footer">
            <span class="footer-text">Already have an account?</span>
            <NuxtLink to="/login" class="link-inline">
              Log In
            </NuxtLink>
          </div>
        </section>

        <!-- Step 2: ID Verification -->
        <section v-if="currentStep === 1" class="form-step">
          <header class="step-header">
            <h2 id="step-2-title" class="step-title">ID Verification</h2>
            <p class="step-subtitle">Step 2 of 3</p>
          </header>

          <p class="step-description">
            Please upload clear photos of both sides of your ID document.
          </p>

          <!-- ID Card Uploads -->
          <div class="id-upload-grid">
            <!-- Front Page -->
            <div class="upload-box">
              <label for="id-front" class="upload-label">
                <span class="upload-text">Front of ID</span>
                <span v-if="!idCardFrontPreview" class="upload-icon">
                  <span aria-hidden="true">+</span>
                </span>
              </label>
              <input
                id="id-front"
                ref="idCardFrontInput"
                type="file"
                accept="image/*"
                aria-label="Upload front of ID card"
                aria-describedby="id-front-error"
                @change="handleFileUpload('idCardFront', $event)"
                class="sr-only"
              />
              <div v-if="idCardFrontPreview" class="image-preview">
                <img 
                  :src="idCardFrontPreview" 
                  alt="Front of ID card - preview" 
                  class="preview-image"
                />
              </div>
              <div v-if="idFrontError" id="id-front-error" role="alert" class="form-error">
                {{ idFrontError }}
              </div>
            </div>

            <!-- Back Page -->
            <div class="upload-box">
              <label for="id-back" class="upload-label">
                <span class="upload-text">Back of ID</span>
                <span v-if="!idCardBackPreview" class="upload-icon">
                  <span aria-hidden="true">+</span>
                </span>
              </label>
              <input
                id="id-back"
                ref="idCardBackInput"
                type="file"
                accept="image/*"
                aria-label="Upload back of ID card"
                aria-describedby="id-back-error"
                @change="handleFileUpload('idCardBack', $event)"
                class="sr-only"
              />
              <div v-if="idCardBackPreview" class="image-preview">
                <img 
                  :src="idCardBackPreview" 
                  alt="Back of ID card - preview" 
                  class="preview-image"
                />
              </div>
              <div v-if="idBackError" id="id-back-error" role="alert" class="form-error">
                {{ idBackError }}
              </div>
            </div>
          </div>

          <!-- Error Alert -->
          <AppAlert v-if="error" type="error" role="alert" aria-live="polite" class="mt-6">
            {{ error }}
          </AppAlert>

          <!-- Navigation -->
          <div class="form-actions step-navigation">
            <AppButton
              type="button"
              @click="currentStep--"
              variant="outlined"
              aria-label="Go back to step 1"
            >
              Back
            </AppButton>
            <AppButton
              type="button"
              @click="nextStep"
              variant="flat"
              aria-label="Proceed to step 3: Documents"
            >
              Continue
            </AppButton>
          </div>
        </section>

        <!-- Step 3: Documents -->
        <section v-if="currentStep === 2" class="form-step">
          <header class="step-header">
            <h2 id="step-3-title" class="step-title">Document Upload</h2>
            <p class="step-subtitle">Step 3 of 3</p>
          </header>

          <p class="step-description">
            Please upload documents proving your authority within the company.
          </p>

          <!-- Document Upload -->
          <div class="upload-box upload-box-large">
            <label for="documents" class="upload-label">
              <span class="upload-text">Upload Document</span>
              <span v-if="!documentsPreview" class="upload-icon">
                <span aria-hidden="true">📄</span>
              </span>
            </label>
            <input
              id="documents"
              ref="documentsInput"
              type="file"
              accept="image/*"
              aria-label="Upload company documents"
              aria-describedby="documents-error"
              @change="handleFileUpload('documents', $event)"
              class="sr-only"
            />
            <div v-if="documentsPreview" class="image-preview">
              <img 
                :src="documentsPreview" 
                alt="Company document - preview" 
                class="preview-image"
              />
            </div>
            <div v-if="documentsError" id="documents-error" role="alert" class="form-error">
              {{ documentsError }}
            </div>
          </div>

          <!-- Error Alert -->
          <AppAlert v-if="error" type="error" role="alert" aria-live="polite" class="mt-6">
            {{ error }}
          </AppAlert>

          <!-- Navigation -->
          <div class="form-actions step-navigation">
            <AppButton
              type="button"
              @click="currentStep--"
              variant="outlined"
              aria-label="Go back to step 2"
            >
              Back
            </AppButton>
            <AppButton
              type="button"
              @click="submit"
              variant="flat"
              :disabled="isLoading"
              aria-label="Complete registration"
            >
              {{ isLoading ? 'Registering...' : 'Complete Registration' }}
            </AppButton>
          </div>
        </section>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue"
import type { RegisterRequest, ApiError } from "~/types/auth"
import { useAuthStore } from "~/stores/auth"

definePageMeta({
  layout: "auth",
  ssr: false,
})

const router = useRouter()
const authStore = useAuthStore()

const steps = [
  "Personal Information",
  "ID Verification",
  "Documents",
]

const currentStep = ref(0)
const showSuccess = ref(false)

// Form fields
const name = ref("")
const email = ref("")
const phone = ref("")
const password = ref("")
const password_confirmation = ref("")
const agreedToTerms = ref(false)

// File references
const idCardFrontInput = ref<HTMLInputElement>()
const idCardBackInput = ref<HTMLInputElement>()
const documentsInput = ref<HTMLInputElement>()

const idCardFrontPreview = ref<string>("")
const idCardBackPreview = ref<string>("")
const documentsPreview = ref<string>("")

const idCardFront = ref<File | null>(null)
const idCardBack = ref<File | null>(null)
const documents = ref<File | null>(null)

// Validation errors
const nameError = ref("")
const emailError = ref("")
const phoneError = ref("")
const passwordError = ref("")
const confirmError = ref("")
const termsError = ref("")
const idFrontError = ref("")
const idBackError = ref("")
const documentsError = ref("")
const error = ref("")

const isLoading = ref(false)

/**
 * Get CSS class for step indicator
 */
const getStepClass = (index: number): string => {
  if (currentStep.value > index) return "completed"
  if (currentStep.value === index) return "active"
  return "pending"
}

/**
 * Handle file uploads
 */
const handleFileUpload = (type: string, event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]

  if (!file) return

  const reader = new FileReader()
  reader.onload = (e) => {
    const preview = e.target?.result as string

    if (type === "idCardFront") {
      idCardFront.value = file
      idCardFrontPreview.value = preview
      idFrontError.value = ""
    } else if (type === "idCardBack") {
      idCardBack.value = file
      idCardBackPreview.value = preview
      idBackError.value = ""
    } else if (type === "documents") {
      documents.value = file
      documentsPreview.value = preview
      documentsError.value = ""
    }
  }
  reader.readAsDataURL(file)
}

/**
 * Validate email format
 */
const validateEmail = (emailValue: string): boolean => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(emailValue)
}

/**
 * Move to next step with validation
 */
const nextStep = () => {
  error.value = ""
  nameError.value = ""
  emailError.value = ""
  phoneError.value = ""
  passwordError.value = ""
  confirmError.value = ""
  termsError.value = ""
  idFrontError.value = ""
  idBackError.value = ""
  documentsError.value = ""

  if (currentStep.value === 0) {
    // Validate step 1: Personal Information
    let isValid = true

    if (!name.value.trim()) {
      nameError.value = "Company name is required"
      isValid = false
    }

    if (!email.value.trim()) {
      emailError.value = "Email is required"
      isValid = false
    } else if (!validateEmail(email.value.trim())) {
      emailError.value = "Please enter a valid email address"
      isValid = false
    }

    if (!phone.value.trim()) {
      phoneError.value = "Phone number is required"
      isValid = false
    }

    if (!password.value) {
      passwordError.value = "Password is required"
      isValid = false
    } else if (password.value.length < 8) {
      passwordError.value = "Password must be at least 8 characters"
      isValid = false
    }

    if (password.value !== password_confirmation.value) {
      confirmError.value = "Passwords do not match"
      isValid = false
    }

    if (!agreedToTerms.value) {
      termsError.value = "You must agree to the Terms and Conditions"
      isValid = false
    }

    if (!isValid) return

  } else if (currentStep.value === 1) {
    // Validate step 2: ID Verification
    if (!idCardFront.value) {
      idFrontError.value = "Front of ID is required"
      return
    }
    if (!idCardBack.value) {
      idBackError.value = "Back of ID is required"
      return
    }
  } else if (currentStep.value === 2) {
    // Validate step 3: Documents
    if (!documents.value) {
      documentsError.value = "Document is required"
      return
    }
  }

  currentStep.value++
}

/**
 * Submit registration form
 */
const submit = async () => {
  error.value = ""
  isLoading.value = true

  try {
    const registerRequest: RegisterRequest = {
      name: name.value.trim(),
      email: email.value.trim(),
      phone: phone.value.trim(),
      password: password.value,
      password_confirmation: password_confirmation.value,
    }

    await authStore.register(registerRequest)
    showSuccess.value = true
  } catch (err: any) {
    const apiError = err.response?.data as ApiError
    error.value = apiError?.message || "Registration failed. Please try again."
    console.error("Registration error:", err)
  } finally {
    isLoading.value = false
  }
}

const goHome = () => {
  router.push("/")
}
</script>

<style scoped>
/* ───────────────────────────────────────────────────────── */
/* Register Container Layout (Responsive)                    */
/* ───────────────────────────────────────────────────────── */

.register-container {
  display: flex;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
}

/* Mobile: Stack vertically */
@media (max-width: 768px) {
  .register-container {
    flex-direction: column;
  }
}

/* ───────────────────────────────────────────────────────── */
/* Left Panel (Brand) - Hidden on Mobile */
/* ───────────────────────────────────────────────────────── */

.register-left-panel {
  display: none;
}

@media (min-width: 769px) {
  .register-left-panel {
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

.brand-title {
  font-size: 2.25rem;
  font-weight: 700;
  margin-bottom: 1rem;
  line-height: 1.2;
}

.brand-subtitle {
  font-size: 1.125rem;
  color: rgba(255, 255, 255, 0.9);
}

/* ───────────────────────────────────────────────────────── */
/* Progress Steps Indicator */
/* ───────────────────────────────────────────────────────── */

.progress-steps {
  margin-top: 3rem;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  text-align: left;
}

.progress-step {
  display: flex;
  gap: 1rem;
  align-items: flex-start;
}

.step-indicator {
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.125rem;
  flex-shrink: 0;
  transition: all 0.3s ease;
}

.step-indicator.pending {
  background-color: rgba(255, 255, 255, 0.3);
  color: white;
}

.step-indicator.active {
  background-color: #a78bfa;
  color: white;
  transform: scale(1.1);
}

.step-indicator.completed {
  background-color: #4ade80;
  color: white;
}

.step-label {
  font-size: 0.95rem;
  font-weight: 600;
  padding-top: 0.25rem;
}

/* ───────────────────────────────────────────────────────── */
/* Right Panel (Form) */
/* ───────────────────────────────────────────────────────── */

.register-right-panel {
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
  .register-right-panel {
    width: 50%;
    padding: 3rem 2rem;
  }
}

@media (max-width: 768px) {
  .register-right-panel {
    background-color: white;
    background-image: none;
  }
}

/* ───────────────────────────────────────────────────────── */
/* Success Container */
/* ───────────────────────────────────────────────────────── */

.success-container {
  width: 100%;
  max-width: 500px;
  text-align: center;
}

.success-content {
  padding: 2rem;
}

.success-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 1rem;
}

.success-message {
  font-size: 1rem;
  color: #6b7280;
  line-height: 1.6;
  margin-bottom: 2rem;
}

/* ───────────────────────────────────────────────────────── */
/* Form Wrapper */
/* ───────────────────────────────────────────────────────── */

.register-form-wrapper {
  width: 100%;
  max-width: 500px;
}

/* ───────────────────────────────────────────────────────── */
/* Form Step */
/* ───────────────────────────────────────────────────────── */

.form-step {
  animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.step-header {
  margin-bottom: 2rem;
}

.step-title {
  font-size: 1.875rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
}

.step-subtitle {
  font-size: 0.875rem;
  color: #6b7280;
  margin: 0;
}

.step-description {
  font-size: 0.95rem;
  color: #4b5563;
  margin-bottom: 1.5rem;
  line-height: 1.5;
}

/* ───────────────────────────────────────────────────────── */
/* Form Groups */
/* ───────────────────────────────────────────────────────── */

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  font-size: 0.875rem;
  color: #374151;
  margin: 0;
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

.form-hint {
  font-size: 0.8125rem;
  color: #6b7280;
  margin: 0.25rem 0 0 0;
  line-height: 1.4;
}

.form-error {
  color: #dc2626;
  font-size: 0.875rem;
  font-weight: 500;
  margin-top: 0.25rem;
}

/* ───────────────────────────────────────────────────────── */
/* Checkbox Group */
/* ───────────────────────────────────────────────────────── */

.checkbox-group {
  margin-bottom: 2rem;
}

.checkbox-wrapper {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
}

.checkbox-input {
  width: 1.25rem;
  height: 1.25rem;
  margin-top: 0.15rem;
  cursor: pointer;
  accent-color: #11298a;
  min-width: 1.25rem;
}

.checkbox-input:focus-visible {
  outline: 2px solid #11298a;
  outline-offset: 2px;
  border-radius: 0.25rem;
}

.checkbox-label {
  font-size: 0.875rem;
  color: #374151;
  line-height: 1.5;
  margin: 0;
}

/* Minimal checkbox border styling */
:deep(.checkbox-minimal .v-selection-control) {
  border: none;
}

:deep(.checkbox-minimal .v-checkbox__input) {
  border: 1px solid #d1d5db;
}

/* ───────────────────────────────────────────────────────── */
/* Upload Boxes */
/* ───────────────────────────────────────────────────────── */

.id-upload-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

@media (max-width: 640px) {
  .id-upload-grid {
    grid-template-columns: 1fr;
  }
}

.upload-box {
  border: 2px dashed #d1d5db;
  border-radius: 0.75rem;
  padding: 2rem 1rem;
  text-align: center;
  transition: all 0.2s ease;
  cursor: pointer;
}

.upload-box:hover {
  border-color: #11298a;
  background-color: rgba(17, 41, 138, 0.02);
}

.upload-box:focus-within {
  border-color: #11298a;
  box-shadow: 0 0 0 3px rgba(17, 41, 138, 0.1);
}

.upload-box-large {
  grid-column: 1 / -1;
  padding: 3rem 2rem;
}

.upload-label {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  cursor: pointer;
  font-weight: 600;
  font-size: 0.95rem;
  color: #374151;
}

.upload-label:focus-visible {
  outline: none;
}

.upload-text {
  font-weight: 600;
}

.upload-icon {
  font-size: 2rem;
  color: #11298a;
}

.image-preview {
  margin-top: 1rem;
  border-radius: 0.5rem;
  overflow: hidden;
  max-height: 300px;
}

.preview-image {
  width: 100%;
  height: auto;
  display: block;
  object-fit: cover;
}

/* ───────────────────────────────────────────────────────── */
/* Form Actions */
/* ───────────────────────────────────────────────────────── */

.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
  margin-bottom: 1.5rem;
}

.step-navigation {
  justify-content: space-between;
}

.form-actions > * {
  flex: 1;
}

@media (max-width: 640px) {
  .form-actions {
    flex-direction: column;
  }
}

/* ───────────────────────────────────────────────────────── */
/* Form Footer */
/* ───────────────────────────────────────────────────────── */

.form-footer {
  text-align: center;
  padding-top: 1.5rem;
  border-top: 1px solid #e5e7eb;
  font-size: 0.875rem;
}

.footer-text {
  color: #6b7280;
  margin-right: 0.5rem;
}

.link-inline {
  color: #2563eb;
  text-decoration: none;
  font-weight: 600;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
  outline: none;
  transition: all 0.2s ease;
}

.link-inline:hover {
  color: #1d4ed8;
  text-decoration: underline;
}

.link-inline:focus-visible {
  outline: 2px solid #11298a;
  outline-offset: 2px;
}

/* ───────────────────────────────────────────────────────── */
/* Animations */
/* ───────────────────────────────────────────────────────── */

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* ───────────────────────────────────────────────────────── */
/* Responsive Adjustments */
/* ───────────────────────────────────────────────────────── */

@media (max-width: 640px) {
  .step-title {
    font-size: 1.5rem;
  }

  .form-input {
    font-size: 16px; /* Prevents zoom on iOS */
  }

  .register-form-wrapper {
    max-width: 100%;
  }
}
</style>
