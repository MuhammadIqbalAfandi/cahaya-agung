<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: false,
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
  error: {
    type: String,
    default: null,
  },
  optionLabel: {
    type: String,
    default: 'label',
  },
  optionValue: {
    type: String,
    default: 'value',
  },
  optionDisabled: {
    type: String,
    default: 'disabled',
  },
  optionGroupChildren: {
    type: String,
    default: null,
  },
  optionGroupLabel: {
    type: String,
    default: null,
  },
  options: {
    type: Array,
    required: true,
  },
  modelValue: null,
})

const isError = computed(() => (props.error ? true : false))

const forLabel = computed(() =>
  props.label ? props.label.toLowerCase().replace(/\s+/g, '-') : null
)

const ariaDescribedbyLabel = computed(
  () => props.label.toLowerCase().replace(/\s+/g, '-') + '-error'
)

const selectedDropdownLabel = (value) => {
  const result = props.options.find((option) => {
    if (option !== null) {
      return option[props.optionValue] == value
    }
  })

  if (result) {
    return result[props.optionLabel]
  }
}
</script>

<template>
  <div class="field">
    <label v-if="label" :for="forLabel" :class="labelClass">{{ label }}</label>

    <Dropdown
      class="w-full"
      :class="{ 'p-invalid': isError }"
      :id="forLabel"
      :option-disabled="optionDisabled"
      :option-group-children="optionGroupChildren"
      :option-group-label="optionGroupLabel"
      :option-label="optionLabel"
      :option-value="optionValue"
      :placeholder="placeholder"
      :options="options"
      :model-value="modelValue"
      :disabled="disabled"
      @change="$emit('update:modelValue', $event.value)"
    >
      <template #value="slotProps">
        <div v-if="slotProps.value">
          {{ selectedDropdownLabel(slotProps.value) }}
        </div>
      </template>
    </Dropdown>

    <small
      v-if="error"
      :id="ariaDescribedbyLabel"
      :class="{ 'p-error': isError }"
    >
      {{ error }}
    </small>
  </div>
</template>
