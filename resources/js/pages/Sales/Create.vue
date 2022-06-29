<script setup>
import { useDialog } from 'primevue/usedialog'
import { optionStatus, dialogStyle } from './config'
import CustomerCreate from './Components/Dialog/CustomerCreate.vue'
import Details from './Components/Details.vue'
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import AppAutoComplete from '@/components/AppAutoComplete.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  number: String,
  ppn: String,
  customers: {
    type: Array,
    default: [],
  },
  stockProducts: {
    type: Array,
    default: [],
  },
})

const form = useForm({
  number: props.number,
  status: 'pending',
  price: null,
  qty: null,
  customer: null,
  product: null,
})

const onSubmit = () => {
  form
    .transform((data) => ({
      number: data.number,
      status: data.status,
      price: data.price,
      qty: data.qty,
      customer_id: data.customer.id,
      product_number: data.product.number,
    }))
    .post(route('sales.store'), {
      onSuccess: () => form.reset(),
    })
}

const dialog = useDialog()

const showCreateCustomer = () => {
  dialog.open(CustomerCreate, {
    props: {
      header: 'Tambah Pelanggan',
      ...dialogStyle,
    },
  })
}

const showCreateProduct = () => {
  dialog.open(ProductCreate, {
    props: {
      header: 'Tambah Produk',
      ...dialogStyle,
    },
  })
}

const checkBtnSubmit = () => {
  if (form.price && form.qty && form.customer && form.product) {
    return false
  } else {
    return true
  }
}
</script>

<template>
  <DashboardLayout title="Tambah Penjualan">
    <DynamicDialog />

    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Tambah Penjualan </template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6">
                <AppInputText
                  disabled
                  label="Nomor Penjualan"
                  placeholder="nomor penjualan"
                  :error="form.errors.number"
                  v-model="form.number"
                />
              </div>

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
                <AppAutoComplete
                  label="Pelanggan"
                  placeholder="pelanggan"
                  field="name"
                  refresh-data="customers"
                  v-model="form.customer"
                  :error="form.errors.customer_id"
                  :suggestions="customers"
                >
                  <template #item="slotProps">
                    <template v-if="slotProps.item">
                      <div class="flex flex-column">
                        <span>{{ slotProps.item.name }}</span>
                        <span>{{ slotProps.item.npwp }}</span>
                      </div>
                    </template>
                  </template>

                  <template #empty>
                    <span
                      class="cursor-pointer"
                      style="color: var(--primary-color)"
                      @click="showCreateCustomer"
                    >
                      Tambah Pelanggan
                    </span>
                  </template>
                </AppAutoComplete>
              </div>

              <div class="col-12 md:col-6">
                <AppAutoComplete
                  label="Produk"
                  placeholder="produk"
                  field="name"
                  refresh-data="stockProducts"
                  v-model="form.product"
                  :error="form.errors.product_number"
                  :suggestions="stockProducts"
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
                :disabled="form.processing || checkBtnSubmit()"
                @click="onSubmit"
              />
            </div>
          </template>
        </Card>
      </div>

      <div class="col-12 lg:col-4">
        <Details
          title="Detail Penjualan"
          :number="number"
          :price="form.price"
          :qty="form.qty"
          :ppn="ppn"
          :status="form.status"
          :person="form.customer"
          :product="form.product"
        />
      </div>
    </div>
  </DashboardLayout>
</template>
