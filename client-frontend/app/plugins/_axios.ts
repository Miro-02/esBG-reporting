import axios, { type AxiosInstance, type AxiosError } from 'axios'

export default defineNuxtPlugin(() => {
  const config = useRuntimeConfig()
  
  // Create axios instance with default config
  const api: AxiosInstance = axios.create({
    // Use environment variable for baseURL
    baseURL: config.public.apiBaseUrl,
    
    // For hackathon: disable credentials requirement (CORS is open)
    withCredentials: false,
    
    // Default headers
    headers: {
      'Accept': 'application/json',
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
      // Add auth token from localStorage if it exists
      try {
        const token = localStorage.getItem('auth_token')
        if (token) {
          config.headers.Authorization = `Bearer ${token}`
        }
      } catch (error) {
        // localStorage might not be available in SSR context
        console.debug('Could not read auth token from localStorage:', error)
      }

      // Don't set Content-Type for FormData - let browser set multipart/form-data
      if (!(config.data instanceof FormData)) {
        config.headers['Content-Type'] = 'application/json'
      } else {
        // Remove Content-Type header for FormData so axios doesn't override multipart/form-data
        delete config.headers['Content-Type']
      }

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
        // Log full error details for debugging
        console.error('=== API Error Response ===')
        console.error('URL:', error.config?.url)
        console.error('Method:', error.config?.method?.toUpperCase())
        console.error('Status:', error.response.status)
        console.error('Status Text:', error.response.statusText)
        console.error('Response Headers:', error.response.headers)
        console.error('Response Data:', error.response.data)
        console.error('Request Headers:', error.config?.headers)
        console.error('========================')

        switch (error.response.status) {
          case 401:
            console.error('Unauthorized. Please log in.')
            break
          case 403:
            console.error('Access forbidden.')
            break
          case 404:
            console.error('Resource not found:', error.config?.url)
            console.error('This could be a CORS preflight failure returning 404')
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
        // Handle CORS and other network errors
        console.error('=== Network Error (No Response) ===')
        console.error('URL:', error.config?.url)
        console.error('Method:', error.config?.method?.toUpperCase())
        console.error('BaseURL:', error.config?.baseURL)
        console.error('Error Message:', error.message)
        console.error('XMLHttpRequest Status:', (error.request as XMLHttpRequest).status)
        console.error('This typically means:')
        console.error('  1. CORS preflight (OPTIONS) failed/returned error')
        console.error('  2. Backend server is not running or not responding')
        console.error('  3. Network connectivity issue')
        console.error('Check browser Network tab for:')
        console.error('  - OPTIONS /api/reports/import (should be 200)')
        console.error('  - Look at response headers for Access-Control-Allow-*')
        console.error('==================================')
        console.error('Network error. Please check your connection.')
      } else {
        console.error('=== Error (Unknown) ===')
        console.error('Error message:', error.message)
        console.error('Full error:', error)
        console.error('======================')
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