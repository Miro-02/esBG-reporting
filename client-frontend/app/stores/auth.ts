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

  const login = async (payload: LoginRequest): Promise<LoginResponse> => {
    const res = await $api.post<LoginResponse>('/api/auth/login', payload)
    return res.data
  }

  const register = async (payload: RegisterRequest): Promise<RegisterResponse> => {
    const res = await $api.post<RegisterResponse>('/api/auth/register', payload)
    return res.data
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
    login,
    register,
    forgotPassword,
    resetPassword,
  }
})