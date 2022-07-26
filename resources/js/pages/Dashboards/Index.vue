<script setup>
import CardCount from './Components/CardCount.vue'
import CardProductFavorite from './Components/CardProductFavorite.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'
import { computed } from '@vue/reactivity'

const props = defineProps([
  'productAmount',
  'productFavorites',
  'salePurchaseStatistic',
])

const salePurchase = computed(() => {
  const data = {
    datasets: [
      {
        label: null,
        data: null,
        fill: false,
        backgroundColor: '#2f4860',
        borderColor: '#2f4860',
        tension: 0.4,
      },
      {
        label: null,
        data: null,
        fill: false,
        backgroundColor: '#00bb7e',
        borderColor: '#00bb7e',
        tension: 0.4,
      },
    ],
  }

  let index = 0

  for (const key in props.salePurchaseStatistic) {
    data.datasets[index].label = key
    data.datasets[index].data = props.salePurchaseStatistic[key]

    console.info(props.salePurchaseStatistic[key])

    index++
  }

  return data
})

const barData = {
  labels: [
    'Jan',
    'Feb',
    'Mar',
    'Apr',
    'May',
    'Jun',
    'Jul',
    'Aug',
    'Sep',
    'Oct',
    'Nov',
    'Dec',
  ],
  datasets: [
    {
      label: 'Bulan lalu',
      data: [
        65_000_000, 59_000_000, 80_000_000, 81_000_000, 56_000_000, 55_000_000,
        40_000_000,
      ],
      fill: false,
      backgroundColor: '#2f4860',
      borderColor: '#2f4860',
      tension: 0.4,
    },
    {
      label: 'Bulan ini',
      data: [
        28_000_000, 48_000_000, 40_000_000, 19_000_000, 86_000_000, 27_000_000,
        90_000_000,
      ],
      fill: false,
      backgroundColor: '#00bb7e',
      borderColor: '#00bb7e',
      tension: 0.4,
    },
  ],
}
</script>

<template>
  <DashboardLayout title="Dashboard">
    <div class="grid">
      <div class="col-12">
        <div class="grid">
          <CardCount :products="productAmount" />
        </div>
      </div>

      <div class="col-12 xl:col-6">
        <div class="grid">
          <div class="col-12">
            <div class="card">
              <h5>Pembelian dan Penjualan</h5>

              <Chart type="line" :data="salePurchase" />
            </div>
          </div>

          <div class="col-12">
            <CardProductFavorite :products="productFavorites" />
          </div>
        </div>
      </div>

      <div class="col-12 xl:col-6">
        <div class="grid">
          <div class="col-12">
            <div class="card">
              <h5>Pembelian</h5>

              <Chart type="bar" :data="barData" />
            </div>
          </div>

          <div class="col-12">
            <div class="card">
              <h5>Pendapatan</h5>

              <Chart type="bar" :data="barData" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
