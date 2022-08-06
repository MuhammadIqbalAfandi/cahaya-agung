<script setup>
import { indexTable } from './config'
import AppSearchFilter from '@/components/AppSearchFilter.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppPagination from '@/components/AppPagination.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  initialFilters: Object,
  sales: Object,
})
</script>

<template>
  <DashboardLayout title="Daftar Penjualan">
    <DataTable
      responsive-layout="scroll"
      column-resize-mode="expand"
      :value="sales.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Penjualan</h1>

        <div class="grid">
          <div class="col-12 md:col-8">
            <AppSearchFilter
              placeholder="nama, no hp, status"
              name-param="search"
              :initial-search="initialFilters"
            />
          </div>

          <div
            class="col-12 md:col-4 flex flex-column md:flex-row justify-content-end"
          >
            <AppButtonLink
              label="Tambah Penjualan"
              icon="pi pi-pencil"
              class="p-button-outlined"
              :href="route('sales.create')"
            />
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
            icon="pi pi-eye"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Lihat Detail Penjualan'"
            :href="route('sales.show', data.id)"
          />
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="sales.links" />
  </DashboardLayout>
</template>
