<script setup>
import CardCount from './Components/CardCount.vue'
import CardProductFavorite from './Components/CardProductFavorite.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps([
  'productCounts',
  'productFavorites',
  'saleStatistic',
])

const purchaseAndSale = {
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
      label: 'Pembelian',
      data: [65, 59, 80, 81, 56, 55, 40],
      fill: false,
      backgroundColor: '#2f4860',
      borderColor: '#2f4860',
      tension: 0.4,
    },
    {
      label: 'Penjualan',
      data: [28, 48, 40, 19, 86, 27, 90],
      fill: false,
      backgroundColor: '#00bb7e',
      borderColor: '#00bb7e',
      tension: 0.4,
    },
  ],
}

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

const lineOptions = null

const productCounts = props.productCounts
</script>

<template>
  <DashboardLayout title="Dashboard">
    <div class="grid">
      <div class="col-12">
        <div class="grid">
          <CardCount :products="productCounts" />
        </div>
      </div>

      <div class="col-12 xl:col-6">
        <div class="grid">
          <div class="col-12">
            <div class="card">
              <h5>Pembelian dan Penjualan</h5>

              <Chart
                type="line"
                :data="purchaseAndSale"
                :options="lineOptions"
              />
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

              <Chart type="bar" :data="barData" :options="lineOptions" />
            </div>
          </div>

          <div class="col-12">
            <div class="card">
              <h5>Pendapatan</h5>

              <Chart type="bar" :data="barData" :options="lineOptions" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
