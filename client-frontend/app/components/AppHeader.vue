<template>
  <header class="!bg-[#11298a] h-[100px] flex items-center" elevation="0">
    <div class="w-full max-w-7xl mx-auto flex items-center gap-8">
      <!-- Logo -->
      <NuxtLink to="/" class="no-underline">
        <img src="/logo.svg" alt="ESG Logo" class="h-8" />
      </NuxtLink>

      <!-- Spacer -->
      <div class="flex-1"></div>

      <!-- Navigation Links and Buttons -->
      <div class="flex gap-6 items-center">
        <NuxtLink to="/" class="no-underline text-white hover:text-gray-300 text-[20px] font-medium">
          Home
        </NuxtLink>
        
        <!-- Public Links (shown when not logged in) -->
        <template v-if="!authStore.isLoggedIn">
          <NuxtLink to="/about-us" class="no-underline text-white hover:text-gray-300 text-[20px] font-medium">
            About us
          </NuxtLink>
          <NuxtLink to="/testimonials" class="no-underline text-white hover:text-gray-300 text-[20px] font-medium">
            Testimonials
          </NuxtLink>
          <NuxtLink to="/contact-us" class="no-underline text-white hover:text-gray-300 text-[20px] font-medium">
            Contact us
          </NuxtLink>
          
          <NuxtLink to="/register">
            <AppButton variant="outlined">
              Sign up
            </AppButton>
          </NuxtLink>
          <NuxtLink to="/login">
            <AppButton variant="flat">
              Log in
            </AppButton>
          </NuxtLink>
        </template>

        <!-- Logged In Links -->
        <template v-else>
          <NuxtLink to="/reports" class="no-underline text-white hover:text-gray-300 text-[20px] font-medium">
            Report history
          </NuxtLink>
          <NuxtLink to="/reports/create" class="no-underline text-white hover:text-gray-300 text-[20px] font-medium">
            Create a report
          </NuxtLink>
          <NuxtLink to="/statistics" class="no-underline text-white hover:text-gray-300 text-[20px] font-medium">
            My statistics
          </NuxtLink>
          
          <AppButton
            @click="handleLogout"
            variant="flat"
          >
            Log out
          </AppButton>
        </template>
      </div>
    </div>

    <slot />
  </header>
</template>

<script setup lang="ts">
const authStore = useAuthStore()
const router = useRouter()

const handleLogout = async () => {
  await authStore.logout()
  router.push('/')
}

onMounted(() => {
  authStore.checkLoginStatus()
})
</script>
