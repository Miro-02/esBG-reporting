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
  const { $api } = useNuxtApp()
  const isLoggedIn = ref(false)

  const login = async (payload: LoginRequest): Promise<LoginResponse> => {
    const res = await $api.post<LoginResponse>('/api/auth/login', payload)
    isLoggedIn.value = true
    return res.data
  }

  const register = async (payload: RegisterRequest): Promise<RegisterResponse> => {
    const res = await $api.post<RegisterResponse>('/api/auth/register', payload)
    isLoggedIn.value = true
    return res.data
  }

  const logout = async () => {
    try {
      await $api.post('/api/auth/logout')
    } catch (error) {
      console.error('Logout error:', error)
    }
    isLoggedIn.value = false
  }

  const checkLoginStatus = () => {
    const token = useCookie('access_token')
    isLoggedIn.value = !!token.value
  }

  const forgotPassword = async (payload: ForgotPasswordRequest): Promise<ForgotPasswordResponse> => {
    const res = await $api.post<ForgotPasswordResponse>('/api/auth/forgot-password', payload)
    return res.data
  }

  const resetPassword = async (token: string, payload: ResetPasswordRequest): Promise<ResetPasswordResponse> => {
    const res = await $api.post<ResetPasswordResponse>(`/api/auth/reset-password/${token}`, payload)
    return res.data
  }

  return {
    isLoggedIn,
    login,
    register,
    logout,
    checkLoginStatus,
    forgotPassword,
    resetPassword,
  }
})