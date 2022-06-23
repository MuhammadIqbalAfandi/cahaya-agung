<script setup>
import { Inertia } from '@inertiajs/inertia'
import { useConfirm } from 'primevue/useconfirm'
import { useForm } from '@/components/useForm'
import AppInputText from '@/components/AppInputText.vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'

const props = defineProps({
  customer: Object,
})

const form = useForm({
  name: props.customer.name,
  address: props.customer.address,
  phone: props.customer.phone,
  npwp: props.customer.npwp,
})

const deleteConfirm = useConfirm()

const onDelete = () => {
  deleteConfirm.require({
    message: `Yakin akan menghapus (${props.customer.name}) ?`,
    header: 'Hapus Pelanggan',
    acceptLabel: 'Hapus',
    rejectLabel: 'Batalkan',
    accept: () => {
      Inertia.delete(route('customers.destroy', props.customer.id))
    },
    reject: () => {
      deleteConfirm.close()
    },
  })
}

const onSubmit = () => {
  form.put(route('customers.update', props.customer.id))
}
</script>

<template>
  <DashboardLayout title="Ubah Pelanggan">
    <ConfirmDialog />

    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Ubah Pelanggan </template>
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
            <div class="grid">
              <div
                class="col-12 md:col-6 flex flex-column md:flex-row justify-content-center md:justify-content-start"
              >
                <Button
                  label="Hapus"
                  icon="pi pi-trash"
                  class="p-button-outlined p-button-danger"
                  @click="onDelete"
                />
              </div>

              <div
                class="col-12 md:col-6 flex flex-column md:flex-row justify-content-center md:justify-content-end"
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
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
