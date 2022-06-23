<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  readOnly: {
    type: Boolean,
    required: false,
  },
  placeholder: {
    type: String,
    required: true,
  },
  error: {
    type: String,
    default: null,
  },
  editorStyle: null,
  modelValue: null,
})

const isError = computed(() => (props.error ? true : false))

const forLabel = computed(() =>
  props.label ? props.label.toLowerCase().replace(/\s+/g, '-') : null
)

const ariaDescribedbyLabel = computed(
  () => props.label.toLowerCase().replace(/\s+/g, '-') + '-error'
)
</script>

<template>
  <div class="field">
    <label v-if="label" :for="forLabel">{{ label }}</label>

    <Editor
      :read-only="readOnly"
      :model-value="modelValue"
      :editor-style="editorStyle"
      :placeholder="placeholder"
      @text-change="$emit('update:modelValue', $event.htmlValue)"
    >
      <template #toolbar>
        <slot name="toolbar" />
      </template>
    </Editor>

    <small
      v-if="error"
      :id="ariaDescribedbyLabel"
      :class="{ 'p-error': isError }"
    >
      {{ error }}
    </small>
  </div>
</template>
