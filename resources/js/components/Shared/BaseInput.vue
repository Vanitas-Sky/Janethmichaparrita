<template>
  <div class="w-full">
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700 mb-2">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <div class="relative">
      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :required="required"
        @input="$emit('update:modelValue', $event.target.value)"
        :class="[
          'w-full px-4 py-2 rounded-lg border-2 transition-colors',
          'focus:outline-none focus:ring-2 focus:ring-blue-500',
          error ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-blue-400',
          disabled && 'bg-gray-100 text-gray-500 cursor-not-allowed',
        ]"
      />
      <span v-if="icon" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
        <slot name="icon"></slot>
      </span>
    </div>
    <p v-if="error" class="mt-1 text-sm text-red-500">{{ error }}</p>
    <p v-if="helpText" class="mt-1 text-sm text-gray-500">{{ helpText }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  modelValue: {
    type: [String, Number],
    default: '',
  },
  type: {
    type: String,
    default: 'text',
  },
  label: {
    type: String,
    default: null,
  },
  placeholder: {
    type: String,
    default: '',
  },
  error: {
    type: String,
    default: null,
  },
  helpText: {
    type: String,
    default: null,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  required: {
    type: Boolean,
    default: false,
  },
  icon: {
    type: Boolean,
    default: false,
  },
  id: {
    type: String,
    default: () => `input-${Math.random().toString(36).substr(2, 9)}`,
  },
})

defineEmits(['update:modelValue'])
</script>
