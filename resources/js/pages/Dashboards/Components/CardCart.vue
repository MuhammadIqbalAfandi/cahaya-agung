<script setup>
defineProps({
  title: {
    type: String,
  },
  description: {
    type: String,
  },
})
</script>

<template>
  <div class="card">
    <h5 class="mb-1">{{ title }}</h5>
    <span>{{ description }}</span>

    <Chart v-bind="$attrs" />
  </div>
</template>
