<script setup>
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  supplier: Object,
})

const form = useForm({
  name: props.supplier.name,
  address: props.supplier.address,
  email: props.supplier.email,
  phone: props.supplier.phone,
  npwp: props.supplier.npwp,
})

const onSubmit = () => {
  form.put(route('suppliers.update', props.supplier.id))
}
</script>

<template>
  <DashboardLayout title="Ubah Supplier">
    <div class="grid">
      <div class="col-12">
        <Card>
          <template #title> Ubah Supplier </template>
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
                  label="Alamat"
                  placeholder="alamat"
                  :error="form.errors.address"
                  v-model="form.address"
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
                  label="No HP"
                  placeholder="no hp"
                  type="number"
                  :error="form.errors.phone"
                  v-model="form.phone"
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
