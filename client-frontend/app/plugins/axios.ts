import axios, { type AxiosInstance, type AxiosError } from 'axios'

export default defineNuxtPlugin(() => {
  const config = useRuntimeConfig()
  
  // Create axios instance with default config
  const api: AxiosInstance = axios.create({
    // Use environment variable for baseURL
    baseURL: config.public.apiBaseUrl,
    
    // Send cookies with requests (required for Laravel Sanctum)
    withCredentials: true,
    
    // Default headers
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
    },
    
    // Timeout after 30 seconds
    timeout: 30000,
  })

  // ========================================
  // REQUEST INTERCEPTOR
  // ========================================
  api.interceptors.request.use(
    (config) => {
      // Add auth token if exists
      // const token = useCookie('auth_token')
      // if (token.value) {
      //   config.headers.Authorization = `Bearer ${token.value}`
      // }

      return config
    },
    (error) => {
      console.error('Request error:', error)
      return Promise.reject(error)
    }
  )

  // ========================================
  // RESPONSE INTERCEPTOR
  // ========================================
  api.interceptors.response.use(
    (response) => response,
    (error: AxiosError) => {
      const apiError = error.response?.data as any

      if (error.response) {
        switch (error.response.status) {
          case 401:
            console.error('Unauthorized. Please log in.')
            break
          case 403:
            console.error('Access forbidden.')
            break
          case 404:
            console.error('Resource not found:', error.config?.url)
            break
          case 419:
            console.error('Session expired. Please refresh the page.')
            break
          case 422:
            console.error('Validation errors:', apiError?.errors)
            break
          case 500:
            console.error('Server error. Please try again later.')
            break
          default:
            console.error('API Error:', error.response.status, apiError?.message)
        }
      } else if (error.request) {
        console.error('Network error. Please check your connection.')
      } else {
        console.error('Error:', error.message)
      }

      return Promise.reject(error)
    }
  )

  return {
    provide: {
      api
    }
  }
})