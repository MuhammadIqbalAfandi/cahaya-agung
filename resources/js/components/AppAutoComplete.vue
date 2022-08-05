<script setup>
import { computed, onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  label: {
    type: String,
    required: false,
  },
  error: {
    type: String,
    default: null,
  },
  empty: {
    type: Boolean,
    default: false,
  },
  refreshData: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['update:modelValue'])

const isError = computed(() => (props.error ? true : false))

const ariaDescribedbyLabel = computed(
  () => props.label?.toLowerCase().replace(/\s+/g, '-') + '-error'
)

let param = props.refreshData.slice(0, -1).replace('-', '_')

const removeParams = (...params) => {
  const urlParams = new URLSearchParams(location.search)

  params.forEach((value) => urlParams.delete(value))

  history.replaceState({}, '', `${location.pathname}?${urlParams}`)
}

const onInput = (event) => {
  if (event.target.value === '') {
    removeParams(param)
  }

  emit('update:modelValue', event.target.value)
}

const onComplete = (event) => {
  Inertia.reload({
    data: {
      [param]: event.query,
    },
    only: [props.refreshData],
  })
}
</script>

<template>
  <div class="field">
    <label>{{ label }}</label>

    <AutoComplete
      forceSelection
      class="w-full"
      inputClass="w-full"
      :class="{ 'p-invalid': isError }"
      v-bind="$attrs"
      @input="onInput"
      @item-select="$emit('update:modelValue', $event.value)"
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
          'mb-2': empty,
          'p-error': isError,
        }"
        :aria-describedby="ariaDescribedbyLabel"
      >
        {{ error }}
      </small>

      <small v-if="empty" class="mt-1">
        <slot name="empty" />
      </small>
    </div>
  </div>
</template>
