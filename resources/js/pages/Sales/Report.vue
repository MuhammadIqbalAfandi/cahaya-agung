<script setup>
import { reportTable } from './config'
import AppFilterDateRange from '@/components/AppFilterDateRange.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  params: Object,
  sales: Object,
})
</script>

<template>
  <DashboardLayout title="Laporan Penjualan">
    <DataTable
      responsive-layout="scroll"
      column-resize-mode="expand"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Laporan Penjualan</h1>

        <div class="grid">
          <div class="col-12 sm:col-6 lg:col-4">
            <AppFilterDateRange
              placeholder="filter waktu..."
              refresh-data="sales"
              :initial-filter="params.filters"
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
  </DashboardLayout>
</template>
