<script setup>
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { pickBy } from 'lodash'
import AppDropdown from '@/components/AppDropdown.vue'

const props = defineProps({
  initialDropdown: {
    type: Object,
    required: true,
  },
  nameParam: {
    type: String,
    required: true,
  },
})

const removeParams = (...params) => {
  const urlParams = new URLSearchParams(location.search)

  params.forEach((value) => urlParams.delete(value))

  history.replaceState({}, '', `${location.pathname}?${urlParams}`)
}

const status = ref(props.initialDropdown[props.nameParam])

watch(status, (value) => {
  removeParams(props.nameParam, 'page')

  Inertia.reload({
    data: pickBy({
      [props.nameParam]: value,
    }),
  })
})
</script>

<template>
  <AppDropdown v-model="status" />
</template>
