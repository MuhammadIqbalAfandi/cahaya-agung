<script setup>
import { reportTable, filterOptionStatus } from './config'
import AppDateRangeFilter from '@/components/AppDateRangeFilter.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppResetFilter from '@/components/AppResetFilter.vue'
import AppPagination from '@/components/AppPagination.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'
import AppDropdownFilter from '@/components/AppDropdownFilter.vue'

defineProps({
  initialFilters: Object,
  purchases: {
    type: Object,
    default: {
      data: [],
      links: [],
      total: 0,
    },
  },
})

const exportExcel = () => {
  return '/purchases/report/excel' + location.search
}
</script>

<template>
  <DashboardLayout title="Laporan Pembelian">
    <DataTable
      responsive-layout="scroll"
      column-resize-mode="expand"
      :value="purchases.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Laporan Pembelian</h1>

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
              placeholder="status"
              name-param="status"
              :initial-dropdown="initialFilters"
              :options="filterOptionStatus"
            />
          </div>

          <div class="col-12 sm:col-6 lg:col-4">
            <AppResetFilter :url="route('purchases.report')" />
          </div>

          <div class="col-12">
            <AppButtonLink
              v-if="purchases.total"
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

    <AppPagination :links="purchases.links" />
  </DashboardLayout>
</template>
