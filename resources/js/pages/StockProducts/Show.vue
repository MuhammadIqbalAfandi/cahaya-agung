<script setup>
import { detailTable, filterOptionCategory } from './config'
import AppPagination from '@/components/AppPagination.vue'
import AppDateRangeFilter from '@/components/AppDateRangeFilter.vue'
import AppDropdownFilter from '@/components/AppDropdownFilter.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppResetFilter from '@/components/AppResetFilter.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  initialFilters: Object,
  productId: Number,
  productNumber: String,
  historyStockProducts: {
    type: Object,
    default: {
      data: [],
      links: [],
      total: 0,
    },
  },
})

const exportExcel = () => {
  if (location.search.length) {
    return (
      '/stock-products/history/excel' +
      location.search +
      `&product_number=${props.productNumber}`
    )
  } else {
    return `/stock-products/history/excel?product_number=${props.productNumber}`
  }
}
</script>

<template>
  <DashboardLayout title="History Stok Produk">
    <DataTable
      responsiveLayout="scroll"
      :value="historyStockProducts.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>History Stok Produk</h1>

        <div class="grid">
          <div class="col-12 sm:col-6 lg:col-4">
            <AppDateRangeFilter
              placeholder="filter waktu..."
              :name-param="['start_date', 'end_date']"
              :initial-date-rage="initialFilters"
            />
          </div>

          <div class="col-12 sm:col-6 lg:col-4">
            <AppDropdownFilter
              placeholder="category"
              name-param="category"
              :initial-dropdown="initialFilters"
              :options="filterOptionCategory"
            />
          </div>

          <div class="col-12 sm:col-6 lg:col-4">
            <AppResetFilter :url="route('stock-products.history', productId)" />
          </div>

          <div class="col-12 flex flex-column sm:flex-row">
            <AppButtonLink
              v-if="historyStockProducts.total"
              label="Export excel"
              class-button="p-button-outlined md:w-16rem"
              icon="pi pi-file-excel"
              :inertia-link="false"
              :href="exportExcel()"
            />
          </div>
        </div>
      </template>

      <Column
        v-for="value in detailTable"
        :key="value.field"
        :field="value.field"
        :header="value.header"
      />

      <Column>
        <template #body="{ data }">
          <Badge
            v-if="data.category === 'Penambahan'"
            :value="data.category"
            severity="success"
            class="mr-2"
          ></Badge>

          <Badge
            v-if="data.category === 'Pengurangan'"
            :value="data.category"
            severity="danger"
            class="mr-2"
          ></Badge>
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="historyStockProducts.links" />
  </DashboardLayout>
</template>
