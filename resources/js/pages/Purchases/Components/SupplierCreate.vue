<script setup>
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'

const form = useForm({
  name: null,
  address: null,
  phone: null,
  email: null,
  npwp: null,
})

const onSubmit = () => {
  form.post(route('suppliers.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
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
        label="Alamat"
        placeholder="alamat"
        :error="form.errors.address"
        v-model="form.address"
      />
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        label="No HP"
        placeholder="no hp"
        type="number"
        :error="form.errors.phone"
        v-model="form.phone"
      />
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        label="Surel"
        placeholder="surel"
        :error="form.errors.email"
        v-model="form.email"
      />
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        label="NPWP"
        placeholder="npwp"
        type="number"
        :error="form.errors.npwp"
        v-model="form.npwp"
      />
    </div>
  </div>
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
