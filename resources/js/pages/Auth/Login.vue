<script setup>
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'
import AppPassword from '@/components/AppPassword.vue'
import AuthLayout from '@/layouts/Auth/AuthLayout.vue'

const form = useForm({
  username: '',
  password: '',
  remember: false,
})

const onSubmit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <AuthLayout title="Sign In">
    <template #header> Selamat Datang Kembali! </template>

    <AppInputText
      v-model="form.username"
      label="Nama Pengguna"
      placeholder="nama pengguna"
      label-class="text-900 text-xl font-medium mb-2"
      :error="form.errors.username"
    />

    <AppPassword
      v-model="form.password"
      label="Kata Sandi"
      placeholder="Kata Sandi"
      label-class="text-900 text-xl font-medium mb-2"
      :error="form.errors.password"
    />

    <Button
      @click="onSubmit"
      label="Masuk"
      :disabled="form.processing"
      class="w-full p-3 text-xl"
    />
  </AuthLayout>
</template>
