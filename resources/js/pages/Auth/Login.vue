<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3'
import { useFormErrorReset } from '@/components/useFormErrorReset'
import AppInputText from '@/components/AppInputText.vue'
import AppPassword from '@/components/AppPassword.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'

const form = useForm({
  username: '',
  password: '',
  remember: false,
})

useFormErrorReset(form)

const onSubmit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <Head title="Sign In" />

  <AuthLayout>
    <template #header> Masuk untuk melanjutkan </template>

    <AppInputText
      v-model="form.username"
      label="Nama Pengguna"
      placeholder="nama pengguna"
      :error="form.errors.username"
    />

    <AppPassword
      v-model="form.password"
      label="Kata Sandi"
      placeholder="Kata Sandi"
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
