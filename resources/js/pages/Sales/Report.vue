<script setup>
import { reportTable } from './config'
import AppDateRangeFilter from '@/components/AppDateRangeFilter.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppPagination from '@/components/AppPagination.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'
import AppResetFilter from '@/components/AppResetFilter.vue'

defineProps({
  initialFilters: Object,
  sales: {
    type: Object,
    default: {
      data: [],
      links: [],
      total: 0,
    },
  },
})

const exportExcel = () => {
  return route('sales.report.excel', location.search)
}
</script>

<template>
  <DashboardLayout title="Laporan Penjualan">
    <DataTable
      responsive-layout="scroll"
      column-resize-mode="expand"
      :value="sales.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Laporan Penjualan</h1>

        <div class="grid">
          <div class="col-12 sm:col-6 lg:col-4">
            <AppDateRangeFilter
              placeholder="filter waktu..."
              :url="route('sales.report')"
              :refresh-data="['sales']"
              :initial-filter="initialFilters"
            />
          </div>

          <div class="col-12 sm:col-6 lg:col-4">
            <AppResetFilter :url="route('sales.report')" />
          </div>

          <div class="col-12">
            <AppButtonLink
              v-if="sales.total"
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
        v-for="value in reportTable"
        :field="value.field"
        :header="value.header"
        :key="value.field"
      />
    </DataTable>

    <AppPagination :links="sales.links" />
  </DashboardLayout>
</template>
