<script setup>
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'
import AppPassword from '@/components/AppPassword.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  user: Object,
  roles: Array,
})

const form = useForm({
  name: props.user.name,
  username: props.user.username,
  role_id: props.user.role_id,
})

const onSubmit = () => {
  form.put(route('users.update', props.user.id))
}

const formChangePassword = useForm({
  old_password: '',
  new_password: '',
  new_password_confirmation: '',
})

const onChangePassword = () => {
  formChangePassword.post(route('users.change-password', props.user.id), {
    onSuccess: () => formChangePassword.reset(),
  })
}
</script>

<template>
  <DashboardLayout title="Profil Saya">
    <div class="grid">
      <div class="col-12">
        <Card>
          <template #title>Profil Saya</template>

          <template #content>
            <TabView lazy>
              <TabPanel header="Ubah Profil">
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

                  <div
                    class="col-12 flex flex-column sm:flex-row justify-content-end"
                  >
                    <Button
                      label="Simpan"
                      icon="pi pi-check"
                      class="p-button-outlined"
                      :disabled="form.processing"
                      @click="onSubmit"
                    />
                  </div>
                </div>
              </TabPanel>
              <TabPanel header="Ubah Kata Sandi">
                <div class="grid">
                  <div class="col-12">
                    <AppPassword
                      label="Kata Sandi Lama"
                      placeholder="kata sandi lama"
                      promptLabel="Masukan Kata Sandi"
                      weakLabel="Lemah"
                      mediumLabel="Sedang"
                      strongLabel="Sangat Kuat"
                      :toggleMask="true"
                      :error="formChangePassword.errors.old_password"
                      v-model="formChangePassword.old_password"
                    />
                  </div>

                  <div class="col-12">
                    <AppPassword
                      label="Kata Sandi Baru"
                      placeholder="kata sandi baru"
                      promptLabel="Masukan Kata Sandi"
                      weakLabel="Lemah"
                      mediumLabel="Sedang"
                      strongLabel="Sangat Kuat"
                      :toggleMask="true"
                      :error="formChangePassword.errors.new_password"
                      v-model="formChangePassword.new_password"
                    />
                  </div>

                  <div class="col-12">
                    <AppPassword
                      label="Konfirmasi Kata Sandi"
                      placeholder="konfirmasi kata sandi"
                      promptLabel="Masukan Kata Sandi"
                      weakLabel="Lemah"
                      mediumLabel="Sedang"
                      strongLabel="Sangat Kuat"
                      :toggleMask="true"
                      v-model="formChangePassword.new_password_confirmation"
                    />
                  </div>

                  <div
                    class="col-12 flex flex-column sm:flex-row justify-content-end"
                  >
                    <Button
                      label="Simpan"
                      icon="pi pi-check"
                      class="p-button-outlined"
                      :disabled="formChangePassword.processing"
                      @click="onChangePassword"
                    />
                  </div>
                </div>
              </TabPanel>
            </TabView>
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
