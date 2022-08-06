<script setup>
import { detailTable } from './config'
import AppButtonLink from '@/components/AppButtonLink.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  customer: Object,
  historyPurchase: Object,
})
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
          @row-click="detail($event.data)"
        >
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
  </DashboardLayout>
</template>
