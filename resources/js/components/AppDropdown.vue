<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: false,
  },
  error: {
    type: String,
    default: null,
  },
})

const isError = computed(() => (props.error ? true : false))

const ariaDescribedbyLabel = computed(
  () => props.label.toLowerCase().replace(/\s+/g, '-') + '-error'
)
</script>

<template>
  <div class="field">
    <label v-if="label">{{ label }}</label>

    <Dropdown
      class="w-full"
      option-label="label"
      option-value="value"
      option-disabled="disabled"
      :class="{ 'p-invalid': isError }"
      v-bind="$attrs"
      @change="$emit('update:modelValue', $event.value)"
    >
    </Dropdown>

    <small
      v-if="error"
      :aria-describedby="ariaDescribedbyLabel"
      :class="{ 'p-error': isError }"
    >
      {{ error }}
    </small>
  </div>
</template>
