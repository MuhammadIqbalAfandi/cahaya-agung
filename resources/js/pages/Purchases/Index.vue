<script setup>
import { indexTable } from './config'
import AppSearchFilter from '@/components/AppSearchFilter.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppPagination from '@/components/AppPagination.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  initialFilters: Object,
  purchases: Object,
})
</script>

<template>
  <DashboardLayout title="Daftar Pembelian">
    <DataTable
      responsiveLayout="scroll"
      :value="purchases.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Pembelian</h1>

        <div class="grid">
          <div class="col-12 md:col-8">
            <AppSearchFilter
              placeholder="nama, email, no hp, status"
              name-param="search"
              :initial-search="initialFilters"
            />
          </div>

          <div
            class="col-12 md:col-4 flex flex-column md:flex-row justify-content-end"
          >
            <AppButtonLink
              label="Tambah Pembelian"
              icon="pi pi-pencil"
              class="p-button-outlined"
              :href="route('purchases.create')"
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
            v-if="data.status == 'pending'"
            icon="pi pi-pencil"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Ubah Pembelian'"
            :href="route('purchases.edit', data.id)"
          />

          <AppButtonLink
            v-else
            icon="pi pi-chevron-right"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Lihat Detail Pembelian'"
            :href="route('purchases.show', data.id)"
          />
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="purchases.links" />
  </DashboardLayout>
</template>
