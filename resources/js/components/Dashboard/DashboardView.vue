<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <Navbar />

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-8">
      <!-- Statistics Cards -->
      <StatisticsCards :stats="stats" />

      <!-- Inventory Table -->
      <InventoryTable
        :equipment="equipment"
        @add-equipment="openAddModal"
        @edit-equipment="openEditModal"
        @delete-equipment="confirmDelete"
      />
    </div>

    <!-- Equipment Modal -->
    <EquipmentModal
      :is-open="isModalOpen"
      :equipment="selectedEquipment"
      :laboratories="laboratories"
      @close="closeModal"
      @save="handleSaveEquipment"
    />

    <!-- Delete Confirmation Dialog -->
    <Teleport to="body">
      <Transition name="modal">
        <div v-if="isDeleteDialogOpen" class="fixed inset-0 z-50 overflow-y-auto">
          <!-- Backdrop -->
          <div
            class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
            @click="isDeleteDialogOpen = false"
          ></div>

          <!-- Dialog -->
          <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-sm w-full">
              <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                  <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 0v2m0-6v-2m0-6h.01M7 9H5.5A1.5 1.5 0 004 10.5v3A1.5 1.5 0 005.5 15H7"></path>
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">
                  ¿Eliminar equipo?
                </h3>
                <p class="text-sm text-gray-500 text-center mb-4">
                  {{ equipmentToDelete?.name }} será eliminado permanentemente.
                </p>
                <div class="flex gap-3">
                  <button
                    @click="isDeleteDialogOpen = false"
                    class="flex-1 px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                  >
                    Cancelar
                  </button>
                  <BaseButton
                    variant="danger"
                    :loading="isDeleting"
                    class="flex-1"
                    @click="handleDeleteEquipment"
                  >
                    Eliminar
                  </BaseButton>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import { useEquipmentStore } from '../../stores/equipment'
import Navbar from './Navbar.vue'
import StatisticsCards from './StatisticsCards.vue'
import InventoryTable from './InventoryTable.vue'
import EquipmentModal from './EquipmentModal.vue'
import BaseButton from '../Shared/BaseButton.vue'
import { Teleport } from 'vue'

const router = useRouter()
const authStore = useAuthStore()
const equipmentStore = useEquipmentStore()

const equipment = ref([])
const laboratories = ref([])
const stats = reactive({
  total_equipment: 0,
  equipment_in_maintenance: 0,
  low_stock_alerts: 0,
})

const isModalOpen = ref(false)
const selectedEquipment = ref(null)
const isDeleteDialogOpen = ref(false)
const equipmentToDelete = ref(null)
const isDeleting = ref(false)

onMounted(async () => {
  // Redirect to login if not authenticated
  if (!authStore.isAuthenticated) {
    router.push({ name: 'login' })
    return
  }

  // Load initial data
  await loadEquipment()
  await loadStatistics()
  await loadLaboratories()
})

const loadEquipment = async () => {
  try {
    const data = await equipmentStore.fetchEquipment()
    equipment.value = data.data || []
  } catch (error) {
    console.error('Error loading equipment:', error)
  }
}

const loadStatistics = async () => {
  try {
    const data = await equipmentStore.fetchStats()
    Object.assign(stats, data)
  } catch (error) {
    console.error('Error loading statistics:', error)
  }
}

const loadLaboratories = async () => {
  try {
    const data = await equipmentStore.fetchLaboratories()
    laboratories.value = data.laboratories || []
  } catch (error) {
    console.error('Error loading laboratories:', error)
  }
}

const openAddModal = () => {
  selectedEquipment.value = null
  isModalOpen.value = true
}

const openEditModal = (item) => {
  selectedEquipment.value = { ...item }
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
  selectedEquipment.value = null
}

const handleSaveEquipment = async (formData) => {
  try {
    if (formData.isEditing) {
      await equipmentStore.updateEquipment(selectedEquipment.value.id, formData)
    } else {
      await equipmentStore.createEquipment(formData)
    }
    closeModal()
    await loadEquipment()
    await loadStatistics()
  } catch (error) {
    console.error('Error saving equipment:', error)
  }
}

const confirmDelete = (item) => {
  equipmentToDelete.value = item
  isDeleteDialogOpen.value = true
}

const handleDeleteEquipment = async () => {
  isDeleting.value = true
  try {
    await equipmentStore.deleteEquipment(equipmentToDelete.value.id)
    isDeleteDialogOpen.value = false
    equipmentToDelete.value = null
    await loadEquipment()
    await loadStatistics()
  } catch (error) {
    console.error('Error deleting equipment:', error)
  } finally {
    isDeleting.value = false
  }
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
