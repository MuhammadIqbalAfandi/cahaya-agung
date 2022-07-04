<script setup>
import { Inertia } from '@inertiajs/inertia'
import { optionStatus } from './config'
import { cartTable } from './config'
import Details from './Components/Details.vue'
import Cart from './Components/Cart.vue'
import { useProductCart } from './Composables/useProductCart'
import { onShowDialog } from './Composables/onShowDialog'
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import AppAutoComplete from '@/components/AppAutoComplete.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  number: String,
  ppn: Number,
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
  status: 'pending',
  price: null,
  qty: null,
  customer: null,
  product: null,
  ppn: props.ppn,
  checkedPpn: false,
})

const onSubmit = () => {
  form
    .transform((data) => ({
      number: props.number,
      status: data.status,
      ppn: data.checkedPpn,
      customer_id: data.customer.id,
      products: productCart,
    }))
    .post(route('purchases.store'), {
      onSuccess: () => {
        form.reset()

        onClearProduct()

        Inertia.reload({ only: ['number'] })
      },
    })
}

const {
  productCart,
  onAddProduct,
  onDeleteProduct,
  onClearProduct,
  totalProductPrice,
} = useProductCart(form)

const { onShowCustomerCreate } = onShowDialog()
</script>

<template>
  <DashboardLayout title="Tambah Penjualan">
    <DynamicDialog />

    <div class="grid">
      <div class="col-12 md:col-8">
        <div class="grid">
          <div class="col-12">
            <Card>
              <template #title> Penjual </template>
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
                    <AppAutoComplete
                      empty
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
                          @click="onShowCustomerCreate"
                        >
                          Tambah Pelanggan
                        </span>
                      </template>
                    </AppAutoComplete>
                  </div>
                </div>
              </template>
            </Card>
          </div>

          <div class="col-12">
            <Card>
              <template #title>Produk</template>
              <template #content>
                <div class="grid">
                  <div class="col-12 md:col-6">
                    <AppAutoComplete
                      :disabled="!form.customer?.id"
                      empty
                      label="Produk"
                      placeholder="produk"
                      field="name"
                      refresh-data="stockProducts"
                      v-model="form.product"
                      :error="form.errors.product"
                      :suggestions="stockProducts"
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
                          @click="onShowCreateProduct"
                        >
                          Tambah Produk
                        </span>
                      </template>
                    </AppAutoComplete>
                  </div>

                  <div v-if="form.product?.unit" class="col-12 md:col-6">
                    <AppInputText
                      disabled
                      label="Satuan"
                      placeholder="satuan"
                      v-model="form.product.unit"
                    />
                  </div>

                  <div class="col-12 md:col-6">
                    <AppInputNumber
                      :disabled="!form.customer?.id"
                      label="Harga"
                      placeholder="harga"
                      v-model="form.price"
                    />
                  </div>

                  <div class="col-12 md:col-6">
                    <AppInputText
                      :disabled="!form.customer?.id"
                      label="Kuantitas"
                      placeholder="kuantitas"
                      type="number"
                      v-model="form.qty"
                    />
                  </div>
                </div>
              </template>
              <template #footer>
                <div class="flex flex-column md:flex-row justify-content-end">
                  <Button
                    label="Tambah Produk"
                    icon="pi pi-check"
                    class="p-button-outlined"
                    :disabled="
                      !form.price || !form.qty || !form.product?.number
                    "
                    @click="onAddProduct"
                  />
                </div>
              </template>
            </Card>
          </div>

          <div class="col-12">
            <Cart
              title="Keranjang Produk"
              :ppn="ppn"
              :value-table="productCart"
              :header-table="cartTable"
              v-model:checked-ppn="form.checkedPpn"
              @delete="onDeleteProduct"
            />
          </div>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <Details
          title="Detail Pembelian"
          message="Pastikan semua produk sudah benar"
          :number="number"
          :status="form.status"
          :person="form.customer"
          :product="form.product"
          :price="totalProductPrice()"
          :disabled="
            form.processing ||
            !form.status ||
            !form.customer?.id ||
            productCart.length === 0
          "
          @submit="onSubmit"
        />
      </div>
    </div>
  </DashboardLayout>
</template>
