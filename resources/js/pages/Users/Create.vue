<script setup>
import { useForm } from '@/components/useForm'
import AppInputText from '@/components/AppInputText.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  roles: Array,
})

const form = useForm({
  name: null,
  username: null,
  role_id: null,
})

const onSubmit = () => {
  form.post(route('users.store'), { onSuccess: () => form.reset() })
}
</script>

<template>
  <DashboardLayout title="Tambah User">
    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Tambah User </template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6">
                <AppInputText
                  label="Nama"
                  placeholder="nama"
                  :error="form.errors.name"
                  v-model="form.name"
                />
              </div>

              <div class="col-12 md:col-6">
                <AppInputText
                  label="Nama Pengguna"
                  placeholder="nama pengguna"
                  :error="form.errors.username"
                  v-model="form.username"
                />
              </div>

              <div class="col-12 md:col-6">
                <AppDropdown
                  label="Hak Akses"
                  placeholder="pilih satu"
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
                label="Simpan"
                icon="pi pi-check"
                class="p-button-outlined"
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
