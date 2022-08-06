<script setup>
import { detailTable } from './config'
import AppPagination from '@/components/AppPagination.vue'
import AppDateRangeFilter from '@/components/AppDateRangeFilter.vue'
import AppSearchFilter from '@/components/AppSearchFilter.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppResetFilter from '@/components/AppResetFilter.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  initialFilters: Object,
  customer: Object,
  historyPurchase: {
    type: Object,
    default: {
      data: [],
      links: [],
      total: 0,
    },
  },
})

const exportExcel = () => {
  return '/customers/history-purchase/excel' + location.search
}
</script>

<template>
  <DashboardLayout title="">
    <div class="grid">
      <div class="col-12">
        <Card>
          <template #title>
            <h2 class="text-2xl font-bold">History Pembelian</h2>
          </template>
          <template #content>
            <div class="grid">
              <div class="col-12">
                <div class="grid">
                  <div class="col">
                    <h3 class="text-base">Nama</h3>
                    <span>{{ customer.name }}</span>
                  </div>
                  <div class="col">
                    <h3 class="text-base">Alamat</h3>
                    <span>{{ customer.address }}</span>
                  </div>
                  <div class="col">
                    <h3 class="text-base">No HP</h3>
                    <span>{{ customer.phone }}</span>
                  </div>
                  <div class="col">
                    <h3 class="text-base">NPWP</h3>
                    <span>{{ customer.npwp }}</span>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </Card>
      </div>

      <div class="col-12">
        <DataTable
          responsiveLayout="scroll"
          columnResizeMode="expand"
          :value="historyPurchase.data"
          :rowHover="true"
          :stripedRows="true"
        >
          <template #header>
            <div class="grid">
              <div class="col-12 sm:col-6 lg:col-4">
                <AppDateRangeFilter
                  placeholder="filter waktu..."
                  :name-param="['start_date', 'end_date']"
                  :initial-date-rage="initialFilters"
                />
              </div>

              <div class="col-12 sm:col-6 lg:col-4">
                <AppSearchFilter
                  placeholder="Nomor Produk"
                  name-param="product_number"
                  :initial-search="initialFilters"
                />
              </div>

              <div class="col-12 sm:col-6 lg:col-4">
                <AppResetFilter :url="route('customers.show', customer.id)" />
              </div>

              <div class="col-12">
                <AppButtonLink
                  v-if="historyPurchase.total"
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
              <AppButtonLink
                icon="pi pi-eye"
                class="p-button-icon-only p-button-rounded p-button-text"
                v-tooltip.bottom="'Lihat Detail Penjualan'"
                :href="route('sales.show', data.id)"
              />
            </template>
          </Column>
        </DataTable>
      </div>
    </div>

    <AppPagination :links="historyPurchase.links" />
  </DashboardLayout>
</template>
