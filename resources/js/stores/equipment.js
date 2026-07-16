import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../services/api'

export const useEquipmentStore = defineStore('equipment', () => {
  const equipment = ref([])
  const stats = ref({})
  const laboratories = ref([])

  const fetchEquipment = async (filters = {}) => {
    try {
      const response = await api.get('/api/equipment', { params: filters })
      equipment.value = response.data.data || []
      return response.data
    } catch (error) {
      console.error('Error fetching equipment:', error)
      throw error
    }
  }

  const fetchStats = async () => {
    try {
      const response = await api.get('/api/equipment/stats/dashboard')
      stats.value = response.data
      return response.data
    } catch (error) {
      console.error('Error fetching stats:', error)
      throw error
    }
  }

  const fetchLaboratories = async () => {
    try {
      const response = await api.get('/api/equipment/utilities/laboratories')
      laboratories.value = response.data.laboratories || []
      return response.data
    } catch (error) {
      console.error('Error fetching laboratories:', error)
      throw error
    }
  }

  const createEquipment = async (data) => {
    try {
      const response = await api.post('/api/equipment', data)
      return response.data
    } catch (error) {
      throw new Error(
        error.response?.data?.message || 
        error.response?.data?.errors?.quantity_available?.[0] ||
        'Error al crear equipo'
      )
    }
  }

  const updateEquipment = async (id, data) => {
    try {
      const response = await api.put(`/api/equipment/${id}`, data)
      return response.data
    } catch (error) {
      throw new Error(
        error.response?.data?.message || 
        error.response?.data?.errors?.quantity_available?.[0] ||
        'Error al actualizar equipo'
      )
    }
  }

  const deleteEquipment = async (id) => {
    try {
      const response = await api.delete(`/api/equipment/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Error al eliminar equipo')
    }
  }

  return {
    equipment,
    stats,
    laboratories,
    fetchEquipment,
    fetchStats,
    fetchLaboratories,
    createEquipment,
    updateEquipment,
    deleteEquipment,
  }
})
