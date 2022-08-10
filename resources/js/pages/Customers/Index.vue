<script setup>
import { Inertia } from '@inertiajs/inertia'
import { useConfirm } from 'primevue/useconfirm'
import { indexTable } from './config'
import AppSearchFilter from '@/components/AppSearchFilter.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppPagination from '@/components/AppPagination.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  initialFilters: Object,
  customers: Object,
})

const deleteConfirm = useConfirm()

const onDelete = (data) => {
  deleteConfirm.require({
    message: `Yakin akan menghapus data (${data.name}) ?`,
    header: 'Hapus Pelanggan',
    acceptLabel: 'Iya',
    rejectLabel: 'Tidak',
    accept: () => {
      Inertia.delete(route('customers.destroy', data.id))
    },
    reject: () => {
      deleteConfirm.close()
    },
  })
}
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
            <AppSearchFilter
              placeholder="nama, no hp, npwp"
              name-param="search"
              :initial-search="initialFilters"
            />
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
          <div class="grid gap-2">
            <AppButtonLink
              icon="pi pi-eye"
              class="p-button-icon-only p-button-rounded p-button-text"
              v-tooltip.bottom="'History Pembelian'"
              :href="route('customers.show', data.id)"
            />

            <AppButtonLink
              icon="pi pi-pencil"
              class="p-button-icon-only p-button-rounded p-button-text"
              v-tooltip.bottom="'Ubah Pelanggan'"
              :href="route('customers.edit', data.id)"
            />

            <Button
              v-if="!data.isUsed"
              icon="pi pi-trash"
              class="p-button-icon-only p-button-rounded p-button-text"
              v-tooltip.bottom="'Hapus Pelanggan'"
              @click="onDelete(data)"
            />
          </div>
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="customers.links" />
  </DashboardLayout>
</template>
