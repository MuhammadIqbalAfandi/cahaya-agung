<script setup>
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  url: {
    type: String,
    required: true,
  },
})

const reset = () => {
  Inertia.get(props.url)
}
</script>

<template>
  <Button label="reset" class="p-button-link" @click="reset" />
</template>
