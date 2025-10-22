import api from './api';
import * as SecureStore from 'expo-secure-store';

export interface User {
  id: number;
  name: string;
  email: string;
  is_admin: boolean;
  created_at: string;
  updated_at: string;
}

export interface LoginData {
  email: string;
  password: string;
}

export interface RegisterData {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export interface ForgotPasswordData {
  email: string;
}

export interface ResetPasswordData {
  email: string;
  password: string;
  password_confirmation: string;
  token: string;
}

export const authService = {
  async login(data: LoginData): Promise<{ user: User; token: string }> {
    const response = await api.post('/auth/login', data);
    const { user, token } = response.data;
    await SecureStore.setItemAsync('token', token);
    return { user, token };
  },

  async register(data: RegisterData): Promise<{ user: User; token: string }> {
    const response = await api.post('/auth/register', data);
    const { user, token } = response.data;
    await SecureStore.setItemAsync('token', token);
    return { user, token };
  },

  async logout(): Promise<void> {
    try {
      await api.post('/auth/logout');
    } finally {
      await SecureStore.deleteItemAsync('token');
    }
  },

  async me(): Promise<User> {
    const response = await api.get('/me');
    return response.data;
  },

  async forgotPassword(data: ForgotPasswordData): Promise<void> {
    await api.post('/auth/forgot-password', data);
  },

  async resetPassword(data: ResetPasswordData): Promise<void> {
    await api.post('/auth/reset-password', data);
  },

  async getToken(): Promise<string | null> {
    return await SecureStore.getItemAsync('token');
  },
};
