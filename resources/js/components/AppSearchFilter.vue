<script setup>
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { pickBy } from 'lodash'

const props = defineProps({
  initialSearch: {
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

const search = ref(props.initialSearch[props.nameParam])

watch(search, (value) => {
  removeParams(props.nameParam, 'page')

  Inertia.reload({
    data: pickBy({
      [props.nameParam]: value,
    }),
  })
})
</script>

<template>
  <div class="flex align-items-center gap-3">
    <InputText v-bind="$attrs" v-model="search" />
    <i class="pi pi-search" />
  </div>
</template>
