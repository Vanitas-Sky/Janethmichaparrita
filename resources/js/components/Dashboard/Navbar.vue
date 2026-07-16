<template>
  <nav class="bg-blue-900 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <!-- Logo and Brand -->
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-blue-400 rounded-lg flex items-center justify-center font-bold">
            ET
          </div>
          <h1 class="text-2xl font-bold">EduTech Connect</h1>
        </div>

        <!-- User Info and Logout -->
        <div class="flex items-center gap-4">
          <div class="text-right">
            <p class="font-semibold">{{ user?.name || 'Usuario' }}</p>
            <p class="text-sm text-blue-200">{{ user?.role || 'Coordinador' }}</p>
          </div>
          <BaseButton
            variant="ghost"
            @click="handleLogout"
            class="text-white hover:bg-blue-800"
          >
            Cerrar Sesión
          </BaseButton>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import BaseButton from '../Shared/BaseButton.vue'

const router = useRouter()
const authStore = useAuthStore()

const user = computed(() => authStore.user)

const handleLogout = async () => {
  await authStore.logout()
  router.push({ name: 'login' })
}
</script>
