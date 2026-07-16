import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../services/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('auth_token') || null)
  const isAuthenticated = computed(() => !!token.value)

  const login = async (email, password) => {
    try {
      const response = await api.post('/auth/login', {
        email,
        password,
      })
      
      token.value = response.data.token
      user.value = response.data.user
      localStorage.setItem('auth_token', response.data.token)
      
      return response.data
    } catch (error) {
      const message = error.response?.data?.message || 'Error al iniciar sesión'
      throw new Error(message)
    }
  }

  const logout = async () => {
    try {
      await api.post('/auth/logout')
    } catch (error) {
      console.error('Error during logout:', error)
    } finally {
      token.value = null
      user.value = null
      localStorage.removeItem('auth_token')
    }
  }

  const getCurrentUser = async () => {
    try {
      const response = await api.get('/user')
      user.value = response.data
      return response.data
    } catch (error) {
      token.value = null
      localStorage.removeItem('auth_token')
      throw error
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    login,
    logout,
    getCurrentUser,
  }
})
