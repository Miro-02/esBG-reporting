export default defineRouteMiddleware(async (to, from) => {
  const authStore = useAuthStore()

  // Only check auth status if not already logged in and on the first load
  // This prevents excessive API calls
  if (!authStore.isLoggedIn && !process.server) {
    await authStore.checkAuthStatus()
  }
})
