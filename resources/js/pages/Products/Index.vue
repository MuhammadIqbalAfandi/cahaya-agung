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
  products: Object,
})

const deleteConfirm = useConfirm()

const onDelete = (data) => {
  deleteConfirm.require({
    message: `Yakin akan menghapus data (${data.name}) ?`,
    header: 'Hapus Produk',
    acceptLabel: 'Iya',
    rejectLabel: 'Tidak',
    accept: () => {
      Inertia.delete(route('products.destroy', data.id))
    },
    reject: () => {
      deleteConfirm.close()
    },
  })
}
</script>

<template>
  <DashboardLayout title="Daftar Produk">
    <DataTable
      responsiveLayout="scroll"
      :value="products.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Produk</h1>

        <div class="grid">
          <div class="col-12 md:col-8">
            <AppSearchFilter
              placeholder="nomor, nama"
              name-param="search"
              :initial-search="initialFilters"
            />
          </div>

          <div
            class="col-12 md:col-4 flex flex-column md:flex-row justify-content-end"
          >
            <AppButtonLink
              label="Tambah Produk"
              icon="pi pi-pencil"
              class="p-button-outlined"
              :href="route('products.create')"
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
            v-tooltip.bottom="'Ubah Produk'"
            :href="route('products.edit', data.id)"
          />

          <Button
            v-if="!data.isUsed"
            icon="pi pi-trash"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Hapus Produk'"
            @click="onDelete(data)"
          />
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="products.links" />
  </DashboardLayout>
</template>
