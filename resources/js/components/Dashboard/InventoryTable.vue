<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- Header with Search -->
    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
      <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="w-full md:w-1/3">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Buscar por nombre o SKU..."
            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <BaseButton
          variant="success"
          @click="$emit('add-equipment')"
          class="w-full md:w-auto"
        >
          + Registrar Nuevo Equipo
        </BaseButton>
      </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="bg-blue-900 text-white">
            <th class="px-6 py-3 text-left text-sm font-semibold">SKU</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Nombre del Equipo</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Laboratorio</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Disponible</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Estado</th>
            <th class="px-6 py-3 text-center text-sm font-semibold">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in filteredEquipment"
            :key="item.id"
            class="border-b border-gray-200 hover:bg-gray-50 transition-colors"
          >
            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ item.sku }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ item.name }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">{{ item.laboratory }}</td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <span class="text-sm font-medium">{{ item.quantity_available }}/{{ item.quantity_total }}</span>
                <div v-if="getStockPercentage(item) <= 25" class="flex items-center">
                  <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                </div>
              </div>
            </td>
            <td class="px-6 py-4">
              <span
                :class="[
                  'inline-block px-3 py-1 rounded-full text-xs font-medium',
                  getStatusClass(item.status),
                ]"
              >
                {{ getStatusLabel(item.status) }}
              </span>
            </td>
            <td class="px-6 py-4">
              <div class="flex gap-2 justify-center">
                <button
                  @click="$emit('edit-equipment', item)"
                  class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                  title="Editar"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </button>
                <button
                  @click="$emit('delete-equipment', item)"
                  class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                  title="Eliminar"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </td>
          </tr>

          <!-- Empty State -->
          <tr v-if="filteredEquipment.length === 0">
            <td colspan="6" class="px-6 py-12 text-center">
              <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <p class="text-gray-500 text-lg">No hay equipos registrados</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination Info -->
    <div v-if="equipment.length > 0" class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-sm text-gray-600">
      Mostrando {{ filteredEquipment.length }} de {{ equipment.length }} equipos
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import BaseButton from '../Shared/BaseButton.vue'

const props = defineProps({
  equipment: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits(['add-equipment', 'edit-equipment', 'delete-equipment'])

const searchQuery = ref('')

const filteredEquipment = computed(() => {
  if (!searchQuery.value) return props.equipment

  const query = searchQuery.value.toLowerCase()
  return props.equipment.filter(
    (item) =>
      item.name.toLowerCase().includes(query) ||
      item.sku.toLowerCase().includes(query)
  )
})

const getStatusClass = (status) => {
  const classes = {
    operational: 'bg-green-100 text-green-800',
    maintenance: 'bg-yellow-100 text-yellow-800',
    damaged: 'bg-red-100 text-red-800',
    inactive: 'bg-gray-100 text-gray-800',
  }
  return classes[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
  const labels = {
    operational: 'Operacional',
    maintenance: 'En Mantenimiento',
    damaged: 'Dañado',
    inactive: 'Inactivo',
  }
  return labels[status] || status
}

const getStockPercentage = (equipment) => {
  return equipment.quantity_total > 0
    ? Math.round((equipment.quantity_available / equipment.quantity_total) * 100)
    : 0
}
</script>
