<script setup>
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { pickBy } from 'lodash'

const props = defineProps({
  initialSearch: {
    required: true,
  },
})

const removeParams = (...params) => {
  const urlParams = new URLSearchParams(location.search)

  params.forEach((value) => urlParams.delete(value))

  history.replaceState({}, '', `${location.pathname}?${urlParams}`)
}

const search = ref(props.initialSearch)

watch(search, (search) => {
  removeParams('search', 'page')

  Inertia.reload({
    data: pickBy({ search }),
  })
})
</script>

<template>
  <div class="flex align-items-center gap-3">
    <InputText v-bind="$attrs" v-model="search" />
    <i class="pi pi-search" />
  </div>
</template>
