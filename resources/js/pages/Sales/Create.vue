<script setup>
import { useForm, Head } from '@inertiajs/inertia-vue3'
import { useFormErrorReset } from '@/components/useFormErrorReset'
import { useProductAutoComplete } from './useProductAutoComplete'
import { useCustomerAutoComplete } from './useCustomerAutoComplete'
import { optionStatus } from './config'
import SaleDetails from './Components/SaleDetails.vue'
import AppInputText from '@/components/AppInputText.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import AppAutoComplete from '@/components/AutoComplete.vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'

const props = defineProps({
  number: String,
  customers: {
    type: Array,
    default: [],
  },
  products: {
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

const { customerOnComplete, customerOnSelected, showCreateCustomer } =
  useCustomerAutoComplete(form)

const { productOnComplete, productOnSelected, showCreateProduct } =
  useProductAutoComplete(form)

useFormErrorReset(form)

const onSubmit = () => {
  form
    .transform((data) => ({
      number: data.number,
      status: data.status,
      price: data.price,
      qty: data.qty,
      customer_id: data.customer.id,
      product_id: data.product.number,
    }))
    .post(route('sales.store'), { onSuccess: () => form.reset() })
}

useFormErrorReset(form)

const checkSales = () => {
  if (form.price && form.qty && form.customer && form.product) {
    return false
  } else {
    return true
  }
}
</script>

<template>
  <Head title="Tambah Penjualan" />

  <DashboardLayout>
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
                  v-model="form.customer"
                  :error="form.errors.customer_id"
                  :suggestions="customers"
                  @complete="customerOnComplete"
                  @item-select="customerOnSelected"
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
                  v-model="form.product"
                  :error="form.errors.product_id"
                  :suggestions="products"
                  @complete="productOnComplete"
                  @item-select="productOnSelected"
                >
                  <template #item="slotProps">
                    <template v-if="slotProps.item">
                      <div class="flex flex-column">
                        <span>{{ slotProps.item.number }}</span>
                        <span>{{ slotProps.item.name }}</span>
                      </div>
                    </template>
                  </template>

                  <template #empty>
                    <span
                      class="cursor-pointer"
                      style="color: var(--primary-color)"
                      @click="showCreateProduct"
                    >
                      Tambah Produk
                    </span>
                  </template>
                </AppAutoComplete>
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
                :disabled="form.processing || checkSales()"
                @click="onSubmit"
              />
            </div>
          </template>
        </Card>
      </div>

      <div class="col-12 lg:col-4">
        <SaleDetails
          :sale-number="number"
          :sale-price="form.price"
          :sale-qty="form.qty"
          :sale-status="form.status"
          :customer="form.customer"
          :product="form.product"
        />
      </div>
    </div>
  </DashboardLayout>
</template>
