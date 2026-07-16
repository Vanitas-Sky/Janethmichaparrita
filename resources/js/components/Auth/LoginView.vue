<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
      <!-- Logo and Title -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mb-4">
          <span class="text-white text-2xl font-bold">ET</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">EduTech Connect</h1>
        <p class="text-gray-600">Gestión de Inventarios de Laboratorios</p>
      </div>

      <!-- Login Card -->
      <div class="bg-white rounded-lg shadow-lg p-8">
        <form @submit.prevent="handleLogin">
          <!-- Email Input -->
          <BaseInput
            v-model="form.email"
            type="email"
            label="Correo Institucional"
            placeholder="docente@instituto.edu.mx"
            :error="errors.email"
            required
            icon
            class="mb-4"
          >
            <template #icon>
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
              </svg>
            </template>
          </BaseInput>

          <!-- Password Input -->
          <BaseInput
            v-model="form.password"
            type="password"
            label="Contraseña"
            placeholder="••••••••"
            :error="errors.password"
            required
            icon
            class="mb-2"
          >
            <template #icon>
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
              </svg>
            </template>
          </BaseInput>

          <!-- General Error Message -->
          <div v-if="errors.general" class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-sm text-red-700">{{ errors.general }}</p>
          </div>

          <!-- Login Button -->
          <BaseButton
            variant="primary"
            :loading="isLoading"
            class="w-full mb-4"
          >
            Iniciar Sesión
          </BaseButton>

          <!-- Demo Credentials -->
          <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-gray-700">
            <p class="font-semibold mb-2">Credenciales de Demostración:</p>
            <p>Email: <code class="bg-blue-100 px-2 py-1 rounded">demo@instituto.edu.mx</code></p>
            <p>Contraseña: <code class="bg-blue-100 px-2 py-1 rounded">password</code></p>
          </div>
        </form>
      </div>

      <!-- Footer -->
      <p class="text-center text-gray-500 text-sm mt-6">
        © 2026 EduTech Connect. Todos los derechos reservados.
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import BaseInput from '../Shared/BaseInput.vue'
import BaseButton from '../Shared/BaseButton.vue'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
  email: '',
  password: '',
})

const errors = ref({
  email: null,
  password: null,
  general: null,
})

const isLoading = ref(false)

const validateForm = () => {
  errors.value = { email: null, password: null, general: null }

  if (!form.value.email) {
    errors.value.email = 'El correo es requerido'
  } else if (!isValidEmail(form.value.email)) {
    errors.value.email = 'Por favor ingresa un correo válido'
  }

  if (!form.value.password) {
    errors.value.password = 'La contraseña es requerida'
  } else if (form.value.password.length < 6) {
    errors.value.password = 'La contraseña debe tener al menos 6 caracteres'
  }

  return !errors.value.email && !errors.value.password
}

const isValidEmail = (email) => {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return re.test(email)
}

const handleLogin = async () => {
  if (!validateForm()) return

  isLoading.value = true

  try {
    await authStore.login(form.value.email, form.value.password)
    router.push({ name: 'dashboard' })
  } catch (error) {
    errors.value.general = error.message || 'Error al iniciar sesión. Verifica tus credenciales.'
  } finally {
    isLoading.value = false
  }
}
</script>
