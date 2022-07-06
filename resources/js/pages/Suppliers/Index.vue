<script setup>
import { Inertia } from '@inertiajs/inertia'
import { useConfirm } from 'primevue/useconfirm'
import { indexTable } from './config'
import AppSearch from '@/components/AppSearch.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppPagination from '@/components/AppPagination.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  suppliers: Object,
  initialSearch: String,
})

const deleteConfirm = useConfirm()

const onDelete = (data) => {
  deleteConfirm.require({
    message: `Yakin akan menghapus data (${data.name}) ?`,
    header: 'Hapus Supplier',
    acceptLabel: 'Iya',
    rejectLabel: 'Tidak',
    accept: () => {
      Inertia.delete(route('suppliers.destroy', data.id))
    },
    reject: () => {
      deleteConfirm.close()
    },
  })
}
</script>

<template>
  <DashboardLayout title="Daftar Supplier">
    <ConfirmDialog />

    <DataTable
      responsiveLayout="scroll"
      columnResizeMode="expand"
      :value="suppliers.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>Supplier</h1>

        <div class="grid">
          <div class="col-12 md:col-8">
            <div class="flex align-items-center">
              <AppSearch
                class="w-full md:w-27rem"
                placeholder="nama, no hp, npwp"
                url="/suppliers"
                :initial-search="initialSearch"
              />
            </div>
          </div>

          <div
            class="col-12 md:col-4 flex flex-column md:flex-row justify-content-end"
          >
            <AppButtonLink
              label="Tambah Supplier"
              icon="pi pi-pencil"
              class="p-button-outlined"
              :href="route('suppliers.create')"
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
            v-tooltip.bottom="'Ubah Supplier'"
            :href="route('suppliers.edit', data.id)"
          />

          <Button
            v-if="!data.isUsed"
            icon="pi pi-trash"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Hapus Supplier'"
            @click="onDelete(data)"
          />
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="suppliers.links" />
  </DashboardLayout>
</template>
