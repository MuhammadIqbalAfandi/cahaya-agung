<script setup>
import { watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { pickBy } from 'lodash'
import { useConfirm } from 'primevue/useconfirm'
import { indexTable } from './config'
import { useSearchText } from '@/components/useSearchText'
import DashboardLayout from '@/layouts/DashboardLayout.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import AppPagination from '@/components/AppPagination.vue'

const props = defineProps({
  users: Object,
  initialSearch: String,
})

const { search } = useSearchText(props)

watch(search, () => {
  Inertia.get('/users', pickBy({ search: search.value }), {
    preserveState: true,
  })
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
</script>

<template>
  <DashboardLayout title="Daftar User">
    <ConfirmDialog />

    <DataTable
      responsiveLayout="scroll"
      columnResizeMode="expand"
      :value="users.data"
      :rowHover="true"
      :stripedRows="true"
    >
      <template #header>
        <h1>User</h1>

        <div class="grid">
          <div class="col-12 md:col-8">
            <div class="flex align-items-center">
              <InputText
                class="w-full md:w-27rem"
                placeholder="cari, contoh: tina"
                v-model="search"
              />
            </div>
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
        </template>
      </Column>
    </DataTable>

    <AppPagination :links="users.links" />
  </DashboardLayout>
</template>
