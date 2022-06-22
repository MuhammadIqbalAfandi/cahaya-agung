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
  field: {
    type: String,
    required: true,
  },
  suggestions: {
    type: Array,
    required: true,
  },
  modelValue: null,
})

defineEmits(['complete', 'itemSelect', 'update:modelValue'])

const isError = computed(() => (props.error ? true : false))

const forLabel = computed(() => props.label.toLowerCase().replace(/\s+/g, '-'))

const ariaDescribedbyLabel = computed(
  () => props.label.toLowerCase().replace(/\s+/g, '-') + '-error'
)
</script>

<template>
  <div class="field">
    <label :for="forLabel">{{ label }}</label>

    <AutoComplete
      class="w-full"
      inputClass="w-full"
      :model-value="modelValue"
      :id="forLabel"
      :class="{ 'p-invalid': isError }"
      :field="field"
      :placeholder="placeholder"
      :suggestions="suggestions"
      :auto-highlight="true"
      :disabled="disabled"
      @input="$emit('update:modelValue', $event.target.value)"
      @item-select="$emit('itemSelect', $event)"
      @complete="$emit('complete', $event)"
    >
      <template #item="slotProps">
        <slot name="item" :item="slotProps.item" />
      </template>
    </AutoComplete>

    <div class="flex flex-column">
      <small
        v-if="error"
        class="mt-1"
        :class="{
          'mb-2': suggestions.length === 0 || modelValue.length === 0,
          'p-error': isError,
        }"
        :id="ariaDescribedbyLabel"
      >
        {{ error }}
      </small>

      <small
        v-if="suggestions.length === 0 || modelValue.length === 0"
        class="mt-1"
      >
        <slot name="empty" />
      </small>
    </div>
  </div>
</template>
