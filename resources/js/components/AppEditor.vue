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
    <label v-if="label">{{ label }}</label>

    <Editor
      v-bind="$attrs"
      @text-change="$emit('update:modelValue', $event.htmlValue)"
    >
      <template #toolbar>
        <slot name="toolbar" />
      </template>
    </Editor>

    <small
      v-if="error"
      :aria-describedby="ariaDescribedbyLabel"
      :class="{ 'p-error': isError }"
    >
      {{ error }}
    </small>
  </div>
</template>
