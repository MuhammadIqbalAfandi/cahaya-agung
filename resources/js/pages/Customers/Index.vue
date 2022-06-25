<script setup>
import { indexTable } from './config'
import AppSearch from '@/components/AppSearch.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppPagination from '@/components/AppPagination.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  customers: Object,
  initialSearch: String,
})
</script>

<template>
  <DashboardLayout title="Daftar Pelanggan">
    <DataTable
      responsiveLayout="scroll"
      columnResizeMode="expand"
      :value="customers.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Pelanggan</h1>

        <div class="grid">
          <div class="col-12 md:col-8">
            <div class="flex align-items-center">
              <AppSearch
                class="w-full md:w-27rem"
                placeholder="cari, contoh: tina, 08xx, 0x"
                url="/customers"
                :initial-search="initialSearch"
              />
            </div>
          </div>

          <div
            class="col-12 md:col-4 flex flex-column md:flex-row justify-content-end"
          >
            <AppButtonLink
              label="Tambah Pelanggan"
              icon="pi pi-pencil"
              class="p-button-outlined"
              :href="route('customers.create')"
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
            icon="pi pi-pencil"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Ubah Pelanggan'"
            :href="route('customers.edit', data.id)"
          />
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="customers.links" />
  </DashboardLayout>
</template>
