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
    <div class="flex justify-content-between align-items-center">
      <h5>{{ data.title }}</h5>
    </div>

    <ul class="list-none p-0 m-0">
      <li
        v-for="product in data.data"
        class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
      >
        <span class="text-900 font-medium mr-2 mb-1 md:mb-0">{{
          product.title
        }}</span>

        <div class="mt-2 md:mt-0 flex flex-column align-items-end">
          <div class="mt-1 text-600 text-xs">Profit</div>

          <div
            class="surface-300 border-round overflow-hidden w-10rem lg:w-6rem"
            style="height: 8px"
          >
            <div
              class="bg-orange-500 h-full"
              :style="{ width: `${product.profit}% ` }"
            ></div>
          </div>

          <span class="text-orange-500 ml-3 font-medium"
            >%{{ product.profit }}</span
          >
        </div>
      </li>
    </ul>
  </div>
</template>
