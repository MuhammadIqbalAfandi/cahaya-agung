<script setup>
import { onMounted, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import { useFormErrorReset } from '@/components/useFormErrorReset'
import AppInputText from '@/components/AppInputText.vue'

onMounted(() => {
  Inertia.reload({ only: ['productNumber'] })
})

watch(
  () => usePage().props.value.productNumber,
  (val) => (form.number = val)
)

const form = useForm({
  number: null,
  name: null,
  unit: null,
})

useFormErrorReset(form)

const onSubmit = () => {
  form.post(route('products.store'), { onSuccess: () => form.reset() })
}
</script>

<template>
  <div class="grid">
    <div class="col-12 md:col-6">
      <AppInputText
        disabled
        label="Nomor Produk"
        placeholder="nomor produk"
        :error="form.errors.number"
        v-model="form.number"
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
