<script setup>
defineProps({
  data: {
    required: true,
    type: Object,
  },
})
</script>

<template>
  <div class="card">
    <h5 class="mb-1">{{ data.title }}</h5>
    <span>{{ data.description }}</span>

    <Chart :type="$attrs.type" :data="data.data" />
  </div>
</template>
