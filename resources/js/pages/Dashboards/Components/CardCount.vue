<script setup>
defineProps({
  data: {
    required: true,
    type: Object,
  },
})
</script>

<template>
  <div v-for="product in data.data" class="col-12 lg:col-6 xl:col-3">
    <div class="card mb-0">
      <div class="flex justify-content-between mb-3">
        <div>
          <span class="block text-500 font-medium mb-3">{{
            product.title
          }}</span>
          <div class="text-900 font-medium text-xl">
            {{ product.amount }}
          </div>
        </div>
        <div
          class="flex align-items-center justify-content-center bg-blue-100 border-round"
          style="width: 2.5rem; height: 2.5rem"
        >
          <i class="pi pi-th-large text-blue-500 text-xl"></i>
        </div>
      </div>

      <span class="text-green-500 font-medium">
        {{ product.amountToday }} {{ product.title.toLowerCase() }} {{ ' ' }}
      </span>

      <span class="text-500">
        {{ product.amountTodayDescription.toLowerCase() }}
      </span>
    </div>
  </div>
</template>
