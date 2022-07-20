<script setup>
import { Inertia } from '@inertiajs/inertia'
import { useConfirm } from 'primevue/useconfirm'
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  user: Object,
  roles: Array,
})

const blockConfirm = useConfirm()

const onBlockConfirm = () => {
  blockConfirm.require({
    message: `Yakin akan memblokir (${props.user.username}) ?`,
    header: 'Blokir User',
    acceptLabel: props.user.status ? 'Blokir' : 'Aktifkan',
    rejectLabel: 'Batalkan',
    accept: () => {
      Inertia.delete(route('users.block', props.user.id))
    },
    reject: () => {
      blockConfirm.close()
    },
  })
}

const form = useForm({
  name: props.user.name,
  username: props.user.username,
  role_id: props.user.role_id,
})

const onSubmit = () => {
  form.put(route('users.update', props.user.id))
}
</script>

<template>
  <DashboardLayout title="Ubah User">
    <ConfirmDialog />

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
            <div class="flex flex-column md:flex-row justify-content-end">
              <Button
                v-if="user.role_id !== 1"
                icon="pi pi-ban"
                class="p-button-outlined md:mr-3 mb-3 md:mb-0"
                :class="[user.status ? 'p-button-danger' : 'p-button-success']"
                :label="user.status ? 'Blokir' : 'Aktifkan'"
                @click="onBlockConfirm"
              />

              <Button
                label="Simpan"
                class="p-button-outlined"
                icon="pi pi-check"
                :disabled="form.processing"
                @click="onSubmit"
              />
            </div>
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
