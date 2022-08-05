<script setup>
import { useStatistic } from './Composables/useStatistic'
import { useStatisticDualYear } from './Composables/useStatisticDualYear'
import CardCart from './Components/CardCart.vue'
import CardCount from './Components/CardCount.vue'
import CardProductFavorite from './Components/CardProductFavorite.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps([
  'productAmount',
  'productBestSelling',
  'salePurchaseAmountStatistic',
  'salePriceStatistic',
  'purchasePriceStatistic',
])

const salePurchaseAmountStatistic = useStatistic(
  props.salePurchaseAmountStatistic
)

const salePriceStatistic = useStatisticDualYear(props.salePriceStatistic)

const purchasePriceStatistic = useStatisticDualYear(
  props.purchasePriceStatistic
)
</script>

<template>
  <DashboardLayout title="Dashboard">
    <div class="grid">
      <div class="col-12">
        <div class="grid">
          <CardCount :data="productAmount" />
        </div>
      </div>

      <div class="col-12 xl:col-6">
        <div class="grid">
          <div class="col-12">
            <CardProductFavorite :data="productBestSelling" />
          </div>

          <div class="col-12">
            <CardCart type="line" :data="salePurchaseAmountStatistic" />
          </div>
        </div>
      </div>

      <div class="col-12 xl:col-6">
        <div class="grid">
          <div class="col-12">
            <CardCart type="bar" :data="salePriceStatistic" />
          </div>

          <div class="col-12">
            <CardCart type="bar" :data="purchasePriceStatistic" />
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
