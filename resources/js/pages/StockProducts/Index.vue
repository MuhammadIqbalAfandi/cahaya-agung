<script setup>
import { indexTable } from './config'
import AppSearchFilter from '@/components/AppSearchFilter.vue'
import AppPagination from '@/components/AppPagination.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  stockProducts: Object,
  initialSearch: String,
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

        <AppSearchFilter
          class="w-full md:w-27rem"
          placeholder="nama"
          :url="route('stock-products.index')"
          :initial-search="initialSearch"
        />
      </template>

      <Column
        v-for="value in indexTable"
        :field="value.field"
        :header="value.header"
        :key="value.field"
      />
    </DataTable>

    <AppPagination :links="stockProducts.links" />
  </DashboardLayout>
</template>
