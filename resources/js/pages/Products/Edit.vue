<script setup>
import { useForm, Head } from '@inertiajs/inertia-vue3'
import { useFormErrorReset } from '@/components/useFormErrorReset'
import AppInputText from '@/components/AppInputText.vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'

const props = defineProps({
  product: Object,
})

const form = useForm({
  number: props.product.number,
  name: props.product.name,
  unit: props.product.unit,
})

useFormErrorReset(form)

const onSubmit = () => {
  form.put(route('products.update', props.product.id))
}
</script>

<template>
  <Head title="Ubah Produk" />

  <DashboardLayout>
    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Ubah Produk </template>
          <template #content>
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
