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
  users: Object,
})

const resetConfirm = useConfirm()

const onResetPassword = (data) => {
  resetConfirm.require({
    message: `Yakin mereset kata sandi (${data.name}) ?`,
    header: 'Reset Kata Sandi',
    acceptLabel: 'Iya',
    rejectLabel: 'Tidak',
    accept: () => {
      Inertia.put(route('users.reset-password', data.id))
    },
    reject: () => {
      resetConfirm.close()
    },
  })
}

const deleteConfirm = useConfirm()

const onDelete = (data) => {
  deleteConfirm.require({
    message: `Yakin akan menghapus data (${data.name}) ?`,
    header: 'Hapus User',
    acceptLabel: 'Iya',
    rejectLabel: 'Tidak',
    accept: () => {
      Inertia.delete(route('users.destroy', data.id))
    },
    reject: () => {
      deleteConfirm.close()
    },
  })
}
</script>

<template>
  <DashboardLayout title="Daftar User">
    <DataTable
      responsiveLayout="scroll"
      :value="users.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>User</h1>

        <div class="grid">
          <div class="col-12 md:col-8">
            <AppSearchFilter
              placeholder="nama, nama pengguna"
              name-param="search"
              :initialSearch="initialFilters"
            />
          </div>

          <div
            class="col-12 md:col-4 flex flex-column md:flex-row justify-content-end"
          >
            <AppButtonLink
              label="Tambah User"
              icon="pi pi-pencil"
              class="p-button-outlined"
              :href="route('users.create')"
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
            v-tooltip.bottom="'Ubah User'"
            :href="route('users.edit', data.id)"
          />

          <Button
            v-if="data.role_id !== 1"
            icon="pi pi-key"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Reset Kata Sandi'"
            @click="onResetPassword(data)"
          />

          <Button
            v-if="data.role_id !== 1"
            icon="pi pi-trash"
            class="p-button-icon-only p-button-rounded p-button-text"
            v-tooltip.bottom="'Hapus User'"
            @click="onDelete(data)"
          />
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="users.links" />
  </DashboardLayout>
</template>
