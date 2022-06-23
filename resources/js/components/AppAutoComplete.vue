<script setup>
import { computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'

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
  refreshData: {
    type: String,
    required: true,
  },
  suggestions: {
    type: Array,
    required: true,
  },
  modelValue: null,
})

const emit = defineEmits(['update:modelValue'])

const isError = computed(() => (props.error ? true : false))

const forLabel = computed(() => props.label.toLowerCase().replace(/\s+/g, '-'))

const ariaDescribedbyLabel = computed(
  () => props.label.toLowerCase().replace(/\s+/g, '-') + '-error'
)

const onComplete = (event) => {
  Inertia.reload({
    data: {
      [props.refreshData.slice(0, -1)]: event.query,
    },
    only: [props.refreshData],
  })
}

const onSelect = (event) => {
  emit('update:modelValue', event.value)
}
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
      @item-select="onSelect"
      @complete="onComplete"
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
