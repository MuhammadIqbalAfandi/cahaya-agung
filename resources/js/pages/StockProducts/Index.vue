<script setup>
import { indexTable, stockOptionCategory } from './config'
import AppSearchFilter from '@/components/AppSearchFilter.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppPagination from '@/components/AppPagination.vue'
import AppDropdownFilter from '@/components/AppDropdownFilter.vue'
import AppResetFilter from '@/components/AppResetFilter.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  initialFilters: Object,
  stockProducts: Object,
})
</script>

<template>
  <DashboardLayout title="Daftar Stok Barang">
    <DataTable
      responsive-layout="scroll"
      column-resize-mode="expand"
      :value="stockProducts.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Stok Produk</h1>

        <div class="grid">
          <div class="col-12 sm:col-6 lg:col-4">
            <AppDropdownFilter
              placeholder="category"
              name-param="category"
              :initial-dropdown="initialFilters"
              :options="stockOptionCategory"
            />
          </div>

          <div class="col-12 sm:col-6 lg:col-4">
            <AppSearchFilter
              placeholder="nama"
              name-param="search"
              :initial-search="initialFilters"
            />
          </div>

          <div class="col-12 sm:col-6 lg:col-4">
            <AppResetFilter :url="route('stock-products.index')" />
          </div>
        </div>
      </template>

      <Column
        v-for="value in indexTable"
        :field="value.field"
        :header="value.header"
        :key="value.field"
      />

      <Column>
        <template #body="{ data }">
          <AppButtonLink
            icon="pi pi-chevron-right"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Lihat History'"
            :href="route('stock-products.history', data.productId)"
          />
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="stockProducts.links" />
  </DashboardLayout>
</template>
