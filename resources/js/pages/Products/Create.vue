<script setup>
import { useForm } from '@/components/useForm'
import AppInputText from '@/components/AppInputText.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  number: String,
})

const form = useForm({
  number: props.number,
  name: null,
  unit: null,
})

const onSubmit = () => {
  form.post(route('products.store'), { onSuccess: () => form.reset() })
}
</script>

<template>
  <DashboardLayout title="Tambah Produk">
    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Tambah Produk </template>
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
