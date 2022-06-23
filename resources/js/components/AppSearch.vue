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
  <InputText v-model="search" />
</template>
