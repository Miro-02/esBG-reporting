export interface LoginRequest {
  email: string
  password: string
}

export interface LoginResponse {
  access_token: string
  token_type: string
  expires_in?: number
}

export interface RegisterRequest {
  name: string
  email: string
  password: string
  password_confirmation: string
}

export interface RegisterResponse {
  message?: string
  user?: {
    id: number
    name: string
    email: string
  }
}

export interface ApiError {
  message: string
  errors?: Record<string, string[]>
}

export interface ForgotPasswordRequest {
  email: string;
}

export interface ForgotPasswordResponse {
  message: string;
}

export interface ResetPasswordRequest {
  email: string;
  token: string;
  password: string;
  password_confirmation: string;
}

export interface ResetPasswordResponse {
  message: string;
}
