export default defineNuxtPlugin(async (nuxtApp) => {
  // Check auth status on app initialization
  // This restores the login state when the page is reloaded
  const authStore = useAuthStore()
  
  // Only check auth status if we have a token stored
  // This prevents unnecessary 401 errors on initial load
  try {
    const token = typeof window !== 'undefined' ? localStorage.getItem('auth_token') : null
    if (token) {
      // Token exists, verify it's still valid
      await authStore.checkAuthStatus()
    }
  } catch (error) {
    console.debug('Auth initialization error:', error)
  }
})
