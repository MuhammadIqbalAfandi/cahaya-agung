<script setup>
import { Inertia } from '@inertiajs/inertia'
import AutoComplete from './AutoComplete.vue'

const onComplete = (event) => {
  console.info(event.query)
}

const onItemSelect = (event) => {
  console.info(event.value)
}
</script>

<template>
  <AutoComplete />
</template>
