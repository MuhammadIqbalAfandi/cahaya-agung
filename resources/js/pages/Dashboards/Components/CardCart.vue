<script setup>
const props = defineProps({
  data: {
    required: true,
    type: Object,
  },
})

const showChart =
  Object.keys(props.data.data.datasets[0].data).length ||
  Object.keys(props.data.data.datasets[1].data).length
</script>

<template>
  <div class="card">
    <h5 class="mb-1">{{ data.title }}</h5>
    <span>{{ data.description }}</span>

    <Chart v-if="showChart" :type="$attrs.type" :data="data.data" />
  </div>
</template>
