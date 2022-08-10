<script setup>
import { useForm } from '@/composables/useForm'
import { useState } from '../Composables/useState'
import AppInputText from '@/components/AppInputText.vue'

const props = defineProps({
  company: Object,
})

const form = useForm({
  id: props.company?.id,
  name: props.company?.name,
  address: props.company?.address,
  telephone: props.company?.telephone,
  email: props.company?.email,
  npwp: props.company?.npwp,
})

const { state, setState } = useState()

const onSubmit = () => {
  setState()

  if (state.disable) {
    form.post(route('companies.store'))
  }
}
</script>

<template>
  <div class="grid">
    <div class="col-12">
      <h1 class="text-lg">Profil Perusahaan</h1>
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        label="Nama"
        placeholder="nama"
        :disabled="state.disable"
        :error="form.errors.name"
        v-model="form.name"
      />
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        label="Alamat"
        placeholder="alamat"
        :disabled="state.disable"
        :error="form.errors.address"
        v-model="form.address"
      />
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        type="number"
        label="Nomor Telepon"
        placeholder="nomor telepon"
        :disabled="state.disable"
        :error="form.errors.telephone"
        v-model="form.telephone"
      />
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        label="Email"
        placeholder="email"
        :error="form.errors.email"
        :disabled="state.disable"
        v-model="form.email"
      />
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        type="number"
        label="NPWP"
        placeholder="npwp"
        :error="form.errors.npwp"
        :disabled="state.disable"
        v-model="form.npwp"
      />
    </div>

    <div class="col-12">
      <div class="flex flex-column sm:flex-row justify-content-end">
        <Button
          class="p-button-outlined"
          :icon="state.icon"
          :label="state.label"
          :disabled="form.processing"
          @click="onSubmit"
        />
      </div>
    </div>
  </div>
</template>
