export default defineNuxtPlugin(async (nuxtApp) => {
  // Check auth status on app initialization
  // This restores the login state when the page is reloaded
  const authStore = useAuthStore()
  
  try {
    // First, restore the token from localStorage if it exists
    // This makes the store state consistent with what's persisted
    const token = typeof window !== 'undefined' ? localStorage.getItem('auth_token') : null
    if (token) {
      authStore.token = token
      authStore.isLoggedIn = true
      
      // Then verify the token is still valid with the backend
      // If this fails, the store will keep the token and try again on next API call
      // Only 401 will clear the token (checkAuthStatus handles this)
      await authStore.checkAuthStatus()
    }
  } catch (error) {
    console.debug('Auth initialization error:', error)
    // Don't clear token here - let checkAuthStatus() handle 401 errors
    // Other errors are temporary and shouldn't log the user out
  }
})
