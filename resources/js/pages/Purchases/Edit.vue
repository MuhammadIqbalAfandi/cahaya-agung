<script setup>
import { useForm } from '@/components/useForm'
import { optionStatus } from './config'
import AppDropdown from '@/components/AppDropdown.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppInputText from '@/components/AppInputText.vue'
import Details from './Components/Details.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  purchase: Object,
})

const form = useForm({
  status: props.purchase.status,
  price: props.purchase.price,
  qty: props.purchase.qty,
})

const onSubmit = () => {
  form.put(route('purchases.update', props.purchase.id))
}
</script>

<template>
  <DashboardLayout title="Ubah Pembelian">
    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Ubah Pembelian </template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6">
                <AppDropdown
                  label="Status"
                  placeholder="status"
                  :options="optionStatus"
                  :error="form.errors.status"
                  v-model="form.status"
                />
              </div>

              <div class="col-12 md:col-6">
                <AppInputNumber
                  label="Harga"
                  placeholder="harga"
                  :error="form.errors.price"
                  v-model="form.price"
                />
              </div>

              <div class="col-12 md:col-6">
                <AppInputText
                  label="Kuantitas"
                  placeholder="kuantitas"
                  type="number"
                  :error="form.errors.qty"
                  v-model="form.qty"
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

      <div class="col-12 lg:col-4">
        <Details
          title="Detail Pembelian"
          :number="purchase.number"
          :price="form.price"
          :qty="form.qty"
          :ppn="purchase.ppn"
          :status="form.status"
          :person="purchase.supplier"
          :product="purchase.product"
        />
      </div>
    </div>
  </DashboardLayout>
</template>
