<script setup>
import { useForm } from '@/components/useForm'
import { optionStatus } from './config'
import AppDropdown from '@/components/AppDropdown.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppInputText from '@/components/AppInputText.vue'
import SaleDetails from './Components/SaleDetails.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  sale: Object,
})

const form = useForm({
  status: props.sale.status.value,
  price: props.sale.price,
  qty: props.sale.qty,
})

const onSubmit = () => {
  form.put(route('sales.update', props.sale.id))
}
</script>

<template>
  <DashboardLayout title="Ubah Penjualan">
    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Ubah Penjualan </template>
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
        <SaleDetails
          :sale-number="sale.number"
          :sale-price="form.price"
          :sale-qty="form.qty"
          :sale-status="form.status"
          :customer="sale.customer"
          :product="sale.product"
        />
      </div>
    </div>
  </DashboardLayout>
</template>
