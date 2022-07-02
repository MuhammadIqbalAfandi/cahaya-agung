<script setup>
import { ref, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { pickBy } from 'lodash'

const props = defineProps({
  url: {
    type: String,
    required: true,
  },
  initialSearch: {
    required: true,
  },
})

const search = ref(props.initialSearch)

watch(search, () => {
  Inertia.get(props.url, pickBy({ search: search.value }), {
    preserveState: true,
  })
})
</script>

<template>
  <div class="flex align-items-center gap-3">
    <InputText v-bind="$attrs" v-model="search" />
    <i class="pi pi-search" />
  </div>
</template>
