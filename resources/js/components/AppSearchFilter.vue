<script setup>
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { pickBy } from 'lodash'

const props = defineProps({
  initialSearch: {
    required: true,
  },
  url: {
    type: String,
    required: true,
  },
  refreshData: {
    type: Array,
    default: [],
    required: false,
  },
})

const search = ref(props.initialSearch)

watch(search, (value) => {
  Inertia.get(props.url, pickBy({ search: value }), {
    preserveState: true,
    only: [...props.refreshData],
  })
})
</script>

<template>
  <div class="flex align-items-center gap-3">
    <InputText v-bind="$attrs" v-model="search" />
    <i class="pi pi-search" />
  </div>
</template>
