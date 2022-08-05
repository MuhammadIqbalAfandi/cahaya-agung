<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: true,
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
    <label>{{ label }}</label>

    <InputNumber
      class="w-full"
      input-class="w-full"
      :class="{ 'p-invalid': isError }"
      v-bind="$attrs"
      @input="$emit('update:modelValue', $event.value)"
    />

    <small
      v-if="error"
      :aria-describedby="ariaDescribedbyLabel"
      :class="{ 'p-error': isError }"
    >
      {{ error }}
    </small>
  </div>
</template>
