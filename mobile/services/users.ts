import api from './api';
import { User } from './auth';

export interface CreateUserData {
  name: string;
  email: string;
  password: string;
  is_admin?: boolean;
}

export interface UpdateUserData {
  name?: string;
  email?: string;
  password?: string;
  is_admin?: boolean;
}

export const usersService = {
  async getAll(): Promise<User[]> {
    const response = await api.get('/users');
    // A API retorna um array direto de usuários
    return response.data;
  },

  async getById(id: number): Promise<User> {
    const response = await api.get(`/users/${id}`);
    return response.data;
  },

  async create(data: CreateUserData): Promise<User> {
    const response = await api.post('/users', data);
    return response.data;
  },

  async update(id: number, data: UpdateUserData): Promise<User> {
    const response = await api.put(`/users/${id}`, data);
    return response.data;
  },

  async delete(id: number): Promise<void> {
    await api.delete(`/users/${id}`);
  },
};
