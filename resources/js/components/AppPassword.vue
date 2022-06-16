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

defineEmits(['update:modelValue'])

const isError = computed(() => (props.error ? true : false))

const forLabel = computed(() => props.label.toLowerCase().replace(/\s+/g, '-'))

const ariaDescribedbyLabel = computed(
  () => props.label.toLowerCase().replace(/\s+/g, '-') + '-help'
)
</script>

<template>
  <div class="field">
    <label :for="forLabel">{{ label }}</label>

    <Password
      class="w-full"
      input-class="w-full"
      :promptLabel="promptLabel"
      :weakLabel="weakLabel"
      :mediumLabel="mediumLabel"
      :strongLabel="strongLabel"
      :disabled="disabled"
      :id="forLabel"
      :placeholder="placeholder"
      :aria-describedby="ariaDescribedbyLabel"
      :toggleMask="true"
      :value="modelValue"
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
