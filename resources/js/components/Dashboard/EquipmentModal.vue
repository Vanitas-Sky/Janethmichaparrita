<template>
  <BaseModal
    :is-open="isOpen"
    :title="isEditing ? 'Editar Equipo' : 'Registrar Nuevo Equipo'"
    @close="handleClose"
  >
    <template #default>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- SKU Input -->
        <BaseInput
          v-model="form.sku"
          label="Número de Inventario (SKU)"
          placeholder="EQ-001"
          :error="errors.sku"
          :disabled="isEditing"
          required
        />

        <!-- Equipment Name -->
        <BaseInput
          v-model="form.name"
          label="Nombre del Equipo"
          placeholder="Osciloscopio Digital"
          :error="errors.name"
          required
        />

        <!-- Laboratory -->
        <div class="w-full">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Laboratorio Asignado <span class="text-red-500">*</span>
          </label>
          <select
            v-model="form.laboratory"
            :class="[
              'w-full px-4 py-2 rounded-lg border-2 transition-colors',
              'focus:outline-none focus:ring-2 focus:ring-blue-500',
              errors.laboratory ? 'border-red-500' : 'border-gray-300',
            ]"
            required
          >
            <option value="">Seleccionar laboratorio</option>
            <option v-for="lab in laboratories" :key="lab" :value="lab">
              {{ lab }}
            </option>
          </select>
          <p v-if="errors.laboratory" class="mt-1 text-sm text-red-500">
            {{ errors.laboratory }}
          </p>
        </div>

        <!-- Category -->
        <div class="w-full">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Categoría <span class="text-red-500">*</span>
          </label>
          <select
            v-model="form.category"
            :class="[
              'w-full px-4 py-2 rounded-lg border-2 transition-colors',
              'focus:outline-none focus:ring-2 focus:ring-blue-500',
              errors.category ? 'border-red-500' : 'border-gray-300',
            ]"
            required
          >
            <option value="">Seleccionar categoría</option>
            <option value="electronics">Electrónica</option>
            <option value="microscopes">Microscopios</option>
            <option value="computing">Computadoras</option>
            <option value="chemicals">Reactivos Químicos</option>
            <option value="tools">Herramientas</option>
            <option value="other">Otros</option>
          </select>
          <p v-if="errors.category" class="mt-1 text-sm text-red-500">
            {{ errors.category }}
          </p>
        </div>

        <!-- Quantity Total -->
        <BaseInput
          v-model.number="form.quantity_total"
          type="number"
          label="Cantidad Total"
          min="1"
          step="1"
          :error="errors.quantity_total"
          required
        />

        <!-- Quantity Available -->
        <BaseInput
          v-model.number="form.quantity_available"
          type="number"
          label="Cantidad Disponible"
          min="0"
          step="1"
          :error="errors.quantity_available"
          required
        />

        <!-- Status -->
        <div class="w-full">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Estado <span class="text-red-500">*</span>
          </label>
          <select
            v-model="form.status"
            :class="[
              'w-full px-4 py-2 rounded-lg border-2 transition-colors',
              'focus:outline-none focus:ring-2 focus:ring-blue-500',
              errors.status ? 'border-red-500' : 'border-gray-300',
            ]"
            required
          >
            <option value="">Seleccionar estado</option>
            <option value="operational">Operacional</option>
            <option value="maintenance">En Mantenimiento</option>
            <option value="damaged">Dañado</option>
            <option value="inactive">Inactivo</option>
          </select>
          <p v-if="errors.status" class="mt-1 text-sm text-red-500">
            {{ errors.status }}
          </p>
        </div>

        <!-- Notes -->
        <div class="w-full">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Notas Adicionales
          </label>
          <textarea
            v-model="form.notes"
            placeholder="Información adicional sobre el equipo..."
            rows="3"
            :class="[
              'w-full px-4 py-2 rounded-lg border-2 transition-colors',
              'focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none',
              errors.notes ? 'border-red-500' : 'border-gray-300',
            ]"
          ></textarea>
          <p v-if="errors.notes" class="mt-1 text-sm text-red-500">
            {{ errors.notes }}
          </p>
        </div>

        <!-- General Error -->
        <div v-if="errors.general" class="p-3 bg-red-50 border border-red-200 rounded-lg">
          <p class="text-sm text-red-700">{{ errors.general }}</p>
        </div>
      </form>
    </template>

    <template #footer>
      <button
        @click="handleClose"
        class="flex-1 px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
      >
        Cancelar
      </button>
      <BaseButton
        variant="success"
        :loading="isSaving"
        class="flex-1"
        @click="handleSubmit"
      >
        {{ isEditing ? 'Actualizar' : 'Guardar' }}
      </BaseButton>
    </template>
  </BaseModal>
</template>

<script setup>
import { ref, reactive, watch, computed } from 'vue'
import BaseModal from '../Shared/BaseModal.vue'
import BaseInput from '../Shared/BaseInput.vue'
import BaseButton from '../Shared/BaseButton.vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  equipment: {
    type: Object,
    default: null,
  },
  laboratories: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits(['close', 'save'])

const isEditing = computed(() => !!props.equipment)

const form = reactive({
  sku: '',
  name: '',
  laboratory: '',
  category: '',
  quantity_total: null,
  quantity_available: null,
  status: 'operational',
  notes: '',
})

const errors = ref({})
const isSaving = ref(false)

watch(
  () => props.isOpen,
  (newVal) => {
    if (newVal && props.equipment) {
      Object.assign(form, props.equipment)
    } else if (newVal) {
      resetForm()
    }
  }
)

const resetForm = () => {
  form.sku = ''
  form.name = ''
  form.laboratory = ''
  form.category = ''
  form.quantity_total = null
  form.quantity_available = null
  form.status = 'operational'
  form.notes = ''
  errors.value = {}
}

const validateForm = () => {
  errors.value = {}

  if (!form.sku?.trim()) {
    errors.value.sku = 'El SKU es requerido'
  }

  if (!form.name?.trim()) {
    errors.value.name = 'El nombre del equipo es requerido'
  }

  if (!form.laboratory) {
    errors.value.laboratory = 'El laboratorio es requerido'
  }

  if (!form.category) {
    errors.value.category = 'La categoría es requerida'
  }

  if (form.quantity_total === null || form.quantity_total < 1) {
    errors.value.quantity_total = 'La cantidad total debe ser mayor a 0'
  }

  if (form.quantity_available === null || form.quantity_available < 0) {
    errors.value.quantity_available = 'La cantidad disponible no puede ser negativa'
  }

  if (form.quantity_available > form.quantity_total) {
    errors.value.quantity_available = 'No puede superar la cantidad total'
  }

  if (!form.status) {
    errors.value.status = 'El estado es requerido'
  }

  return Object.keys(errors.value).length === 0
}

const handleSubmit = async () => {
  if (!validateForm()) return

  isSaving.value = true

  try {
    emit('save', {
      ...form,
      isEditing: isEditing.value,
    })
  } catch (error) {
    errors.value.general = error.message || 'Error al guardar el equipo'
  } finally {
    isSaving.value = false
  }
}

const handleClose = () => {
  resetForm()
  emit('close')
}
</script>
