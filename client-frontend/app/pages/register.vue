<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 flex items-center justify-center py-12 px-4">
    <!-- Success State -->
    <div v-if="showSuccess" class="w-full max-w-2xl text-center text-white">
      <div class="mb-8">
        <h1 class="text-5xl font-bold mb-4">ESG</h1>
      </div>
      
      <h2 class="text-5xl font-bold mb-8 leading-tight">
        Your information has been sent successfully!
      </h2>
      
      <p class="text-lg mb-12 text-gray-300">
        * The account will be verified by our team within 24 hours. An email will be sent to you when it is done so you can start filling out your ESG information.
      </p>
      
      <AppButton 
        @click="goHome"
        color="primary"
        class="px-12 py-3"
      >
        Go to home
      </AppButton>
    </div>

    <!-- Registration Form -->
    <div v-else class="w-full max-w-6xl">
      <div class="grid grid-cols-2 gap-8 shadow-lg rounded-lg overflow-hidden bg-white">
        <!-- Left Sidebar -->
        <div class="bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 p-12 text-white flex flex-col justify-between">
          <div>
            <h1 class="text-4xl font-bold mb-4">ESG</h1>
            <h2 class="text-3xl font-bold mb-4">Create your company's account</h2>
            <p class="text-lg mb-12">Use 3 simple steps</p>
          </div>

          <!-- Steps Indicator -->
          <div class="space-y-8">
            <div 
              v-for="(step, index) in steps" 
              :key="index"
              class="flex items-start gap-4"
            >
              <div class="flex flex-col items-center">
                <div 
                  :class="[
                    'w-6 h-6 rounded-full flex items-center justify-center font-bold text-sm transition-all',
                    currentStep > index ? 'bg-green-500' : currentStep === index ? 'bg-purple-500' : 'bg-gray-400'
                  ]"
                >
                  {{ currentStep > index ? '✓' : index + 1 }}
                </div>
                <div v-if="index < steps.length - 1" class="w-0.5 h-12 bg-gray-400 my-2" />
              </div>
              <div class="pt-1">
                <p class="font-semibold">{{ step }}</p>
              </div>
            </div>
          </div>

          <!-- Footer Note -->
          <div class="mt-12 text-sm text-gray-300">
            <p>* The account will be verified by our team within 24 hours. An email will be sent to you when it is done so you can start filling out your ESG information.</p>
          </div>
        </div>

        <!-- Right Content -->
        <div class="p-12 flex flex-col justify-between">
          <!-- Step 1: Personal Information -->
          <div v-if="currentStep === 0" class="space-y-6">
            <div>
              <h3 class="text-2xl font-bold mb-2">1st Step</h3>
            </div>

            <AppTextField 
              v-model="name" 
              label="Full company name"
              placeholder="Enter your full company name"
              class="mb-4"
              variant="outlined"
            />
            <AppTextField 
              v-model="email" 
              label="E-mail"
              type="email"
              placeholder="Enter your e-mail"
              class="mb-4"
              variant="outlined"
            />
            <AppTextField 
              v-model="phone" 
              label="Phone number"
              placeholder="Enter your phone number"
              class="mb-4"
              variant="outlined"
            />
            <AppTextField 
              v-model="password" 
              label="Create your password"
              type="password"
              placeholder="Type your password"
              class="mb-4"
              variant="outlined"
              hint="Must be 8 characters at least"
              persistent-hint
            />
            <AppTextField 
              v-model="password_confirmation" 
              label="Confirm password"
              type="password"
              placeholder="Type your password"
              class="mb-6"
              variant="outlined"
              hint="Must be 8 characters at least"
              persistent-hint
            />

            <AppAlert v-if="error" type="error" class="mb-4">
              {{ error }}
            </AppAlert>

            <v-checkbox
              v-model="agreedToTerms"
              density="comfortable"
            >
              <template #label>
                <span class="text-sm">
                  By creating an account means you agree to the 
                  <NuxtLink to="/terms-and-conditions" class="text-blue-600 font-semibold">
                    Terms and Conditions
                  </NuxtLink>
                  , and our 
                  <NuxtLink to="/" class="text-blue-600 font-semibold">
                    Privacy Policy
                  </NuxtLink>
                </span>
              </template>
            </v-checkbox>
          </div>

          <!-- Step 2: ID Card and Video Chat -->
          <div v-if="currentStep === 1" class="space-y-6">
            <div>
              <h3 class="text-2xl font-bold mb-2">2nd Step</h3>
              <p class="text-gray-600">ID card and video chat</p>
            </div>

            <div>
              <p class="font-semibold mb-4">Photo of your ID card</p>
              
              <!-- ID Card Upload Grid -->
              <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Front Page -->
                <div 
                  class="border-4 border-dashed border-purple-300 rounded-lg p-8 text-center cursor-pointer hover:border-purple-500 transition-colors"
                  @click="triggerFileInput('idCardFront')"
                >
                  <v-icon v-if="!idCardFrontPreview" class="mb-2" color="purple" size="48">
                    mdi-plus
                  </v-icon>
                  <p class="text-sm font-semibold text-gray-700">Add the front page</p>
                  <input
                    ref="idCardFrontInput"
                    type="file"
                    accept="image/*"
                    hidden
                    @change="handleFileUpload('idCardFront', $event)"
                  />
                </div>

                <!-- Back Page -->
                <div 
                  class="border-4 border-dashed border-purple-300 rounded-lg p-8 text-center cursor-pointer hover:border-purple-500 transition-colors"
                  @click="triggerFileInput('idCardBack')"
                >
                  <v-icon v-if="!idCardBackPreview" class="mb-2" color="purple" size="48">
                    mdi-plus
                  </v-icon>
                  <p class="text-sm font-semibold text-gray-700">Add the back page</p>
                  <input
                    ref="idCardBackInput"
                    type="file"
                    accept="image/*"
                    hidden
                    @change="handleFileUpload('idCardBack', $event)"
                  />
                </div>
              </div>

              <!-- Image Previews -->
              <div v-if="idCardFrontPreview || idCardBackPreview" class="grid grid-cols-2 gap-6 mb-6">
                <v-img v-if="idCardFrontPreview" :src="idCardFrontPreview" alt="ID Front" class="rounded-lg" />
                <v-img v-if="idCardBackPreview" :src="idCardBackPreview" alt="ID Back" class="rounded-lg" />
              </div>
            </div>

            <div>
              <p class="font-semibold mb-4">Start your video chat to verify your identity</p>
              <div 
                class="border-4 border-dashed border-purple-300 rounded-lg p-12 text-center cursor-pointer hover:border-purple-500 transition-colors"
              >
                <v-icon class="mb-2" color="purple" size="48">
                  mdi-camera
                </v-icon>
                <p class="text-sm font-semibold text-gray-700">Turn on your camera</p>
              </div>
            </div>

            <AppAlert v-if="error" type="error" class="mt-4">
              {{ error }}
            </AppAlert>
          </div>

          <!-- Step 3: Documents -->
          <div v-if="currentStep === 2" class="space-y-6">
            <div>
              <h3 class="text-2xl font-bold mb-2">3rd Step</h3>
              <p class="text-gray-600">Documents of your title to the firm</p>
            </div>

            <div>
              <p class="font-semibold mb-4">Photo of your Documents</p>
              
              <div 
                class="border-4 border-dashed border-purple-300 rounded-lg p-12 text-center cursor-pointer hover:border-purple-500 transition-colors"
                @click="triggerFileInput('documents')"
              >
                <v-icon v-if="!documentsPreview" class="mb-2" color="purple" size="48">
                  mdi-plus
                </v-icon>
                <p class="text-sm font-semibold text-gray-700">Document</p>
                <input
                  ref="documentsInput"
                  type="file"
                  accept="image/*"
                  hidden
                  @change="handleFileUpload('documents', $event)"
                />
              </div>

              <v-img v-if="documentsPreview" :src="documentsPreview" alt="Documents" class="rounded-lg mt-6" />
            </div>

            <AppAlert v-if="error" type="error" class="mt-4">
              {{ error }}
            </AppAlert>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-4 justify-between mt-12">
            <AppButton 
              v-if="currentStep > 0"
              @click="currentStep--"
              variant="outlined"
              color="primary"
            >
              Back
            </AppButton>

            <div class="flex gap-4 ml-auto">
              <AppButton 
                v-if="currentStep < 2"
                @click="nextStep"
                color="primary"
              >
                Next
              </AppButton>

              <AppButton 
                v-if="currentStep === 2"
                @click="submit"
                color="primary"
                :loading="isLoading"
              >
                Sign Up
              </AppButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { RegisterRequest, ApiError } from '~/types/auth'
import { useAuthStore } from '~/stores/auth'

definePageMeta({
  layout: 'auth',
  ssr: false,
});

const router = useRouter()

const steps = ['Personal information', 'ID card and video chat', 'Documents of your title to the firm']
const currentStep = ref(0)
const showSuccess = ref(false)

// Form fields
const name = ref('')
const email = ref('')
const phone = ref('')
const password = ref('')
const password_confirmation = ref('')
const agreedToTerms = ref(false)

// File uploads
const idCardFrontInput = ref<HTMLInputElement>()
const idCardBackInput = ref<HTMLInputElement>()
const documentsInput = ref<HTMLInputElement>()

const idCardFrontPreview = ref<string>('')
const idCardBackPreview = ref<string>('')
const documentsPreview = ref<string>('')

const idCardFront = ref<File | null>(null)
const idCardBack = ref<File | null>(null)
const documents = ref<File | null>(null)

// State
const error = ref('')
const isLoading = ref(false)

const authStore = useAuthStore()

const triggerFileInput = (type: string) => {
  if (type === 'idCardFront') {
    idCardFrontInput.value?.click()
  } else if (type === 'idCardBack') {
    idCardBackInput.value?.click()
  } else if (type === 'documents') {
    documentsInput.value?.click()
  }
}

const handleFileUpload = (type: string, event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  
  if (!file) return

  const reader = new FileReader()
  reader.onload = (e) => {
    const preview = e.target?.result as string
    
    if (type === 'idCardFront') {
      idCardFront.value = file
      idCardFrontPreview.value = preview
    } else if (type === 'idCardBack') {
      idCardBack.value = file
      idCardBackPreview.value = preview
    } else if (type === 'documents') {
      documents.value = file
      documentsPreview.value = preview
    }
  }
  reader.readAsDataURL(file)
}

const nextStep = () => {
  error.value = ''
  
  if (currentStep.value === 0) {
    // Validate step 1
    if (!name.value.trim()) {
      error.value = 'Full name is required'
      return
    }
    if (!email.value.trim()) {
      error.value = 'Email is required'
      return
    }
    if (!phone.value.trim()) {
      error.value = 'Phone number is required'
      return
    }
    if (!password.value) {
      error.value = 'Password is required'
      return
    }
    if (password.value.length < 8) {
      error.value = 'Password must be at least 8 characters'
      return
    }
    if (password.value !== password_confirmation.value) {
      error.value = 'Passwords do not match'
      return
    }
    if (!agreedToTerms.value) {
      error.value = 'You must agree to the Terms and Conditions'
      return
    }
  }

  currentStep.value++
}

const submit = async () => {
  error.value = ''
  isLoading.value = true
  
  const registerRequest: RegisterRequest = {
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value
  }
  
  try {
    await authStore.register(registerRequest)
    showSuccess.value = true
  } catch (err: any) {
    const apiError = err.response?.data as ApiError
    error.value = apiError?.message || 'Registration failed. Please try again.'
    console.log(err);
  } finally {
    isLoading.value = false
  }
}

const goHome = () => {
  router.push('/')
}
</script>