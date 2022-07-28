<script setup>
defineProps({
  title: {
    required: true,
    type: String,
  },
})
</script>

<template>
  <div class="card">
    <h5>{{ title }}</h5>

    <Chart v-bind="$attrs" />
  </div>
</template>
