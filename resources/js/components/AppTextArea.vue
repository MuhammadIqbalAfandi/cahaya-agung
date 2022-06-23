<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    required: true,
  },
  error: {
    type: String,
    default: null,
  },
  rows: {
    type: Number,
    default: 5,
  },
  cols: {
    type: Number,
    default: 30,
  },
  modelValue: null,
})

const isError = computed(() => (props.error ? true : false))

const forLabel = computed(() => props.label.toLowerCase().replace(/\s+/g, '-'))

const ariaDescribedbyLabel = computed(
  () => props.label.toLowerCase().replace(/\s+/g, '-') + '-error'
)
</script>

<template>
  <div class="field">
    <label :for="forLabel">{{ label }}</label>

    <Textarea
      class="w-full"
      :class="{ 'p-invalid': isError }"
      :id="forLabel"
      :model-value="modelValue"
      :placeholder="placeholder"
      :disabled="disabled"
      :auto-resize="true"
      :rows="rows"
      :cols="cols"
      @input="$emit('update:modelValue', $event.target.value)"
    />

    <small
      v-if="error"
      :id="ariaDescribedbyLabel"
      :class="{ 'p-error': isError }"
    >
      {{ error }}
    </small>
  </div>
</template>
