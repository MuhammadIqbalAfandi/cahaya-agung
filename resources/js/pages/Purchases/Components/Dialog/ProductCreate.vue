<script setup>
import { onMounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'

const getProductNumber = () => {
  Inertia.reload({ only: ['productNumber'] })
}

onMounted(() => getProductNumber())

const form = useForm({
  name: null,
  unit: null,
})

const onSubmit = () => {
  form
    .transform((data) => ({
      number: usePage().props.value.productNumber,
      ...data,
    }))
    .post(route('products.store'), {
      onSuccess: () => form.reset(),
      onFinish: () => getProductNumber(),
    })
}
</script>

<template>
  <div class="grid">
    <div class="col-12 md:col-6">
      <AppInputText
        disabled
        label="Nomor Produk"
        placeholder="nomor produk"
        v-model="$page.props.productNumber"
      />
    </div>

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
        label="Satuan"
        placeholder="satuan"
        :error="form.errors.unit"
        v-model="form.unit"
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
