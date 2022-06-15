<script setup>
import { Inertia } from '@inertiajs/inertia'
import { useForm, Head } from '@inertiajs/inertia-vue3'
import { useConfirm } from 'primevue/useconfirm'
import { useFormErrorReset } from '@/components/useFormErrorReset'
import AppInputText from '@/components/AppInputText.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import AppButtonLink from '@/components/AppButtonLink.vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'

const props = defineProps({
  user: Object,
  roles: Array,
})

const deleteConfirm = useConfirm()

const onDeleteUser = () => {
  deleteConfirm.require({
    message: `Yakin akan menghapus (${props.user.username}) ?`,
    header: 'Hapus User',
    acceptLabel: 'Hapus',
    rejectLabel: 'Batalkan',
    accept: () => {
      Inertia.delete(route('users.destroy', props.user.id))
    },
    reject: () => {
      deleteConfirm.close()
    },
  })
}

const form = useForm({
  name: props.user.name,
  username: props.user.username,
  role_id: props.user.role_id,
})

useFormErrorReset(form)

const onSubmit = () => {
  form.put(route('users.update', props.user.id))
}
</script>

<template>
  <Head title="Ubah User" />

  <DashboardLayout>
    <ConfirmDialog></ConfirmDialog>

    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Edit User </template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6">
                <AppInputText
                  label="Nama"
                  placeholder="nama"
                  :disabled="user.role_id !== 1"
                  :error="form.errors.name"
                  v-model="form.name"
                />
              </div>

              <div class="col-12 md:col-6">
                <AppInputText
                  label="Nama Pengguna"
                  placeholder="nama pengguna"
                  :disabled="user.role_id !== 1"
                  :error="form.errors.username"
                  v-model="form.username"
                />
              </div>

              <div v-if="user.role_id !== 1" class="col-12 md:col-6">
                <AppDropdown
                  label="Hak Akses"
                  placeholder="Pilih satu"
                  v-model="form.role_id"
                  :options="roles"
                  :error="form.errors.role_id"
                />
              </div>
            </div>
          </template>

          <template #footer>
            <div class="grid">
              <div
                class="col-12 md:col-6 flex flex-column md:flex-row justify-content-center md:justify-content-start"
              >
                <Button
                  v-if="$page.props.auth.user.role_id !== user.role_id"
                  label="Hapus"
                  icon="pi pi-trash"
                  class="p-button-outlined p-button-danger"
                  @click="onDeleteUser"
                />
              </div>

              <div
                class="col-12 md:col-6 flex flex-column md:flex-row justify-content-center md:justify-content-end"
              >
                <AppButtonLink
                  label="Blokir"
                  icon="pi pi-ban"
                  method="delete"
                  class="p-button-outlined p-button-danger md:mr-3 mb-3 md:mb-0"
                  :href="route('users.block', user.id)"
                />

                <Button
                  label="Simpan"
                  class="p-button-outlined"
                  icon="pi pi-check"
                  :disabled="form.processing"
                  @click="onSubmit"
                />
              </div>
            </div>
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
