<script setup>
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { pickBy } from 'lodash'
import AppDropdown from '@/components/AppDropdown.vue'

defineProps({
  options: {
    type: Array,
    required: true,
  },
})

const removeParams = (...params) => {
  const urlParams = new URLSearchParams(location.search)

  params.forEach((value) => urlParams.delete(value))

  history.replaceState({}, '', `${location.pathname}?${urlParams}`)
}

const status = ref()

watch(status, (status) => {
  removeParams('status', 'page')

  Inertia.reload({
    data: pickBy({
      status,
    }),
  })
})
</script>

<template>
  <AppDropdown placeholder="status" :options="options" v-model="status" />
</template>
