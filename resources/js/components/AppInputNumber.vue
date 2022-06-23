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
  useGrouping: {
    type: Boolean,
    default: true,
  },
  mode: {
    type: String,
    default: 'decimal',
  },
  currency: {
    type: String,
    default: undefined,
  },
  locale: {
    type: String,
    default: undefined,
  },
  currencyDisplay: {
    type: String,
    default: undefined,
  },
  showButtons: {
    type: Boolean,
    default: false,
  },
  min: {
    type: Number,
    default: null,
  },
  max: {
    type: Number,
    default: null,
  },
  step: {
    type: Number,
    default: 1,
  },
  prefix: {
    type: String,
    default: null,
  },
  suffix: {
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
    <label :for="forLabel">{{ label }}</label>

    <InputNumber
      class="w-full"
      input-class="w-full"
      :currency="currency"
      :currency-display="currencyDisplay"
      :locale="locale"
      :class="{ 'p-invalid': isError }"
      :id="forLabel"
      :placeholder="placeholder"
      :model-value="modelValue"
      :disabled="disabled"
      :prefix="prefix"
      :suffix="suffix"
      :step="step"
      :min="min"
      :max="max"
      :mode="mode"
      :use-grouping="useGrouping"
      :show-buttons="showButtons"
      @input="$emit('update:modelValue', $event.value)"
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
