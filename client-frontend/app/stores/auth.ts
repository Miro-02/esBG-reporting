import { defineStore } from 'pinia'
import type {
  LoginRequest,
  LoginResponse,
  RegisterRequest,
  RegisterResponse,
  ForgotPasswordRequest,
  ForgotPasswordResponse,
  ResetPasswordRequest,
  ResetPasswordResponse,
} from '~/types/auth'

export const useAuthStore = defineStore('auth', () => {
  const isLoggedIn = ref(false)
  const user = ref(null)
  const token = ref<string | null>(null)

  // Get $api lazily when needed, not at store init time
  const getApi = () => {
    const { $api } = useNuxtApp()
    return $api
  }

  const login = async (payload: LoginRequest): Promise<LoginResponse> => {
    const $api = getApi()
    const res = await $api.post<LoginResponse>('/api/auth/login', payload)
    const data = res.data as any
    
    // Store token and user from response
    token.value = data.token
    user.value = data.user
    isLoggedIn.value = true
    
    // Persist token to localStorage for page reloads
    localStorage.setItem('auth_token', data.token)
    
    return res.data
  }

  const register = async (payload: RegisterRequest): Promise<RegisterResponse> => {
    const $api = getApi()
    const res = await $api.post<RegisterResponse>('/api/auth/register', payload)
    isLoggedIn.value = true
    return res.data
  }

  const logout = async () => {
    try {
      const $api = getApi()
      await $api.post('/api/auth/logout')
    } catch (error) {
      console.error('Logout error:', error)
    }
    isLoggedIn.value = false
    user.value = null
    token.value = null
    localStorage.removeItem('auth_token')
  }

  // Check if user is still authenticated with the backend
  const checkAuthStatus = async () => {
    try {
      const $api = getApi()
      const res = await $api.get('/api/auth/me')
      isLoggedIn.value = true
      user.value = res.data.user
    } catch (error) {
      isLoggedIn.value = false
      user.value = null
    }
  }

  // Legacy function - kept for backwards compatibility
  const checkLoginStatus = () => {
    return checkAuthStatus()
  }

  const forgotPassword = async (payload: ForgotPasswordRequest): Promise<ForgotPasswordResponse> => {
    const $api = getApi()
    const res = await $api.post<ForgotPasswordResponse>('/api/auth/forgot-password', payload)
    return res.data
  }

  const resetPassword = async (token: string, payload: ResetPasswordRequest): Promise<ResetPasswordResponse> => {
    const $api = getApi()
    const res = await $api.post<ResetPasswordResponse>(`/api/auth/reset-password/${token}`, payload)
    return res.data
  }

  return {
    isLoggedIn,
    user,
    token,
    login,
    register,
    logout,
    checkAuthStatus,
    checkLoginStatus,
    forgotPassword,
    resetPassword,
  }
})