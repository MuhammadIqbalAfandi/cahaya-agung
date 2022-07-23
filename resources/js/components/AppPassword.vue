<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  labelClass: {
    type: String,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    required: true,
  },
  promptLabel: {
    type: String,
    default: 'Masukan kata sandi',
  },
  weakLabel: {
    type: String,
    default: 'Ah Lemah',
  },
  mediumLabel: {
    type: String,
    default: 'Lumayan',
  },
  strongLabel: {
    type: String,
    default: 'Wow Kuat',
  },
  error: {
    type: String,
    default: null,
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
    <label :for="forLabel" :class="labelClass">{{ label }}</label>

    <Password
      class="w-full"
      input-class="w-full"
      :class="{ 'p-invalid': isError }"
      :promptLabel="promptLabel"
      :weakLabel="weakLabel"
      :mediumLabel="mediumLabel"
      :strongLabel="strongLabel"
      :disabled="disabled"
      :id="forLabel"
      :placeholder="placeholder"
      :toggleMask="true"
      :model-value="modelValue"
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
