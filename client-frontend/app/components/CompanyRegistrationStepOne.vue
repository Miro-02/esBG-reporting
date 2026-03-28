<template>
  <div class="min-h-screen bg-[#f7f7f2]">
    <div class="grid min-h-screen lg:grid-cols-2">
      <aside class="flex min-h-[28rem] flex-col bg-[#1e2b24] px-6 py-8 text-white sm:px-10 lg:px-14 lg:py-10">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.5 5.84" class="w-24">
            <path fill="#8c86aa" d="M5.34,0c1.75,0,2.75.88,2.75,2.4v3.29h-1.99v-1.35c-.23.92-.97,1.5-1.97,1.5-1.05,0-1.75-.64-1.75-1.6,0-1.08.89-1.71,2.44-1.71h1.28v-.13c0-.61-.27-.95-.81-.95s-.77.3-.77.83h-1.98C2.54.87,3.61,0,5.34,0ZM5.14,3.51c-.5,0-.76.17-.76.49s.25.49.67.49c.58,0,1.06-.36,1.06-.8v-.18h-.96Z"/>
            <path fill="#11298a" d="M3.92.17v1.33H1.64v.84h2.07v1.22H1.64v.83h2.35v1.33H0V.17h3.92Z"/>
            <path fill="#8c86aa" d="M15.4.05l-.02.05-1.45,4.14c-.2.56-.46.96-.81,1.21-.35.26-.79.38-1.34.38-.25,0-.53-.03-.85-.08h-.03v-1.25h.04c.21.04.38.05.53.05.33,0,.56-.07.74-.24L10.76.1l-.02-.05h1.67v.03s.67,2.9.67,2.9L13.76.08v-.03h1.65Z"/>
            <path fill="#11298a" d="M16.81,4.53c.62,0,1.07-.3,1.13-.85h-1.17v-.92h2.73v2.97h-1.52v-1.2c-.32.83-.96,1.32-1.78,1.32-1.24,0-2.18-1.14-2.18-2.89S15.18.05,16.79.05c1.35,0,2.44.83,2.67,2.2h-1.62c-.14-.58-.52-.85-1.04-.85-.74,0-1.12.51-1.12,1.55s.39,1.58,1.14,1.58Z"/>
            <path fill="#11298a" d="M11.61,2h-1.56c0-.43-.35-.69-.91-.69-.46,0-.82.18-.82.47,0,.33.32.38,1.06.49l.17.02c.92.13,2.23.32,2.23,1.7,0,1.18-.97,1.85-2.58,1.85-1.71,0-2.6-.75-2.6-2h1.56c0,.46.39.74,1.04.74.55,0,.95-.2.95-.52,0-.35-.33-.4-1.06-.49l-.23-.03c-.88-.11-2.17-.28-2.17-1.62C6.68.71,7.72.05,9.17.05c1.53,0,2.44.73,2.44,1.95Z"/>
          </svg>
        </div>

        <div class="mt-16 max-w-md lg:mt-24">
          <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#9eb3a5]">Company Registration</p>
          <h1 class="mt-4 text-4xl font-semibold leading-tight text-white sm:text-5xl">
            Create your company's account
          </h1>
          <p class="mt-4 text-base text-[#bfd0c3]">
            Use 3 simple steps
          </p>

          <ol class="relative mt-12 flex flex-col gap-5">
            <div class="absolute left-[13px] top-4 bottom-4 w-px bg-[#50665a]"></div>

            <li class="relative flex gap-3">
              <span class="z-10 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#7c6fcd] text-xs font-bold text-white">
                1
              </span>
              <div>
                <p class="text-sm font-bold text-white">Personal information</p>
                <p class="text-xs text-[#8ea394]">Start with the primary contact for the company account.</p>
              </div>
            </li>

            <li class="relative flex gap-3">
              <span class="z-10 flex h-7 w-7 shrink-0 items-center justify-center bg-[#1e2b24] text-xs font-bold text-[#8ea394]">
                2
              </span>
              <div>
                <p class="text-sm font-bold text-white">ID card and video chat</p>
                <p class="text-xs text-[#8ea394]">Verify the identity of the authorized representative.</p>
              </div>
            </li>

            <li class="relative flex gap-3">
              <span class="z-10 flex h-7 w-7 shrink-0 items-center justify-center bg-[#1e2b24] text-xs font-bold text-[#8ea394]">
                3
              </span>
              <div>
                <p class="text-sm font-bold text-white">Documents of your title to the firm</p>
                <p class="text-xs text-[#8ea394]">Upload the legal documents that establish company ownership.</p>
              </div>
            </li>
          </ol>
        </div>

        <p class="mt-12 text-xs leading-6 text-[#93a89a] lg:mt-auto lg:max-w-sm">
          * The account will be verified by our team within 24 hours after all three steps are completed and submitted.
        </p>
      </aside>

      <section class="flex bg-white px-6 py-8 sm:px-10 lg:px-14 lg:py-10">
        <div class="mx-auto flex w-full max-w-xl items-center">
          <div class="w-full">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-[#243229]">1st Step</p>
            <h2 class="mt-3 text-3xl font-semibold text-[#18211b]">Personal information</h2>
            <p class="mt-3 text-sm leading-6 text-[#66756b]">
              Enter the contact details for the person managing your company profile.
            </p>

            <form class="mt-10 space-y-5" @submit.prevent="submit">
              <AppAlert v-if="formError" type="error" variant="tonal" class="mb-2 rounded-2xl">
                {{ formError }}
              </AppAlert>

              <AppTextField
                v-model="fullName"
                label="Full name"
                autocomplete="name"
                variant="solo-filled"
                flat
                rounded="xl"
                bg-color="#f3f4f0"
                color="#1e2b24"
                base-color="#c8d0ca"
                hide-details="auto"
                :error-messages="errors.fullName ? [errors.fullName] : []"
              />

              <AppTextField
                v-model="email"
                label="E-mail"
                type="email"
                autocomplete="email"
                variant="solo-filled"
                flat
                rounded="xl"
                bg-color="#f3f4f0"
                color="#1e2b24"
                base-color="#c8d0ca"
                hide-details="auto"
                :error-messages="errors.email ? [errors.email] : []"
              />

              <AppTextField
                v-model="phoneNumber"
                label="Phone number"
                type="tel"
                autocomplete="tel"
                variant="solo-filled"
                flat
                rounded="xl"
                bg-color="#f3f4f0"
                color="#1e2b24"
                base-color="#c8d0ca"
                hide-details="auto"
                :error-messages="errors.phoneNumber ? [errors.phoneNumber] : []"
              />

              <AppTextField
                v-model="password"
                label="Create password"
                :type="showPassword ? 'text' : 'password'"
                autocomplete="new-password"
                variant="solo-filled"
                flat
                rounded="xl"
                bg-color="#f3f4f0"
                color="#1e2b24"
                base-color="#c8d0ca"
                hide-details="auto"
                hint="Must be 8 characters at least"
                persistent-hint
                :append-inner-icon="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                :error-messages="errors.password ? [errors.password] : []"
                @click:append-inner="showPassword = !showPassword"
              />

              <AppTextField
                v-model="confirmPassword"
                label="Confirm password"
                :type="showConfirmPassword ? 'text' : 'password'"
                autocomplete="new-password"
                variant="solo-filled"
                flat
                rounded="xl"
                bg-color="#f3f4f0"
                color="#1e2b24"
                base-color="#c8d0ca"
                hide-details="auto"
                hint="Must be 8 characters at least"
                persistent-hint
                :append-inner-icon="showConfirmPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                :error-messages="errors.confirmPassword ? [errors.confirmPassword] : []"
                @click:append-inner="showConfirmPassword = !showConfirmPassword"
              />

              <div class="rounded-2xl bg-[#f3f4f0] px-4 py-2">
                <v-checkbox
                  v-model="acceptedTerms"
                  color="#1e2b24"
                  hide-details="auto"
                  density="comfortable"
                  :error-messages="errors.acceptedTerms ? [errors.acceptedTerms] : []"
                >
                  <template #label>
                    <span class="text-sm leading-6 text-[#59685f]">
                      I agree to the
                      <a href="#" class="font-medium text-[#1e2b24] underline decoration-[#7d74c9] underline-offset-4">
                        Terms
                      </a>
                      and
                      <a href="#" class="font-medium text-[#1e2b24] underline decoration-[#7d74c9] underline-offset-4">
                        Privacy Policy
                      </a>
                    </span>
                  </template>
                </v-checkbox>
              </div>

              <AppButton
                type="submit"
                block
                size="x-large"
                rounded="pill"
                class="!mt-8 !h-14 !bg-[#111714] !px-6 !text-sm !font-semibold !normal-case tracking-[0.08em] text-white"
              >
                Sign Up
              </AppButton>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

export interface CompanyRegistrationStepOnePayload {
  fullName: string
  email: string
  phoneNumber: string
  password: string
}

type FormErrors = Partial<Record<'fullName' | 'email' | 'phoneNumber' | 'password' | 'confirmPassword' | 'acceptedTerms', string>>

const emit = defineEmits<{
  next: [payload: CompanyRegistrationStepOnePayload]
}>()

const fullName = ref('')
const email = ref('')
const phoneNumber = ref('')
const password = ref('')
const confirmPassword = ref('')
const acceptedTerms = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const formError = ref('')
const errors = ref<FormErrors>({})

const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

const submit = () => {
  const nextErrors: FormErrors = {}
  formError.value = ''

  if (!fullName.value.trim()) {
    nextErrors.fullName = 'Full name is required.'
  }

  if (!email.value.trim()) {
    nextErrors.email = 'E-mail is required.'
  } else if (!emailPattern.test(email.value)) {
    nextErrors.email = 'Enter a valid e-mail address.'
  }

  if (!phoneNumber.value.trim()) {
    nextErrors.phoneNumber = 'Phone number is required.'
  }

  if (!password.value) {
    nextErrors.password = 'Password is required.'
  } else if (password.value.length < 8) {
    nextErrors.password = 'Password must be at least 8 characters.'
  }

  if (!confirmPassword.value) {
    nextErrors.confirmPassword = 'Please confirm your password.'
  } else if (confirmPassword.value.length < 8) {
    nextErrors.confirmPassword = 'Password must be at least 8 characters.'
  } else if (password.value !== confirmPassword.value) {
    nextErrors.confirmPassword = 'Passwords do not match.'
  }

  if (!acceptedTerms.value) {
    nextErrors.acceptedTerms = 'You must accept the terms to continue.'
  }

  errors.value = nextErrors

  if (Object.keys(nextErrors).length > 0) {
    formError.value = 'Please correct the highlighted fields and try again.'
    return
  }

  emit('next', {
    fullName: fullName.value.trim(),
    email: email.value.trim(),
    phoneNumber: phoneNumber.value.trim(),
    password: password.value,
  })
}
</script>