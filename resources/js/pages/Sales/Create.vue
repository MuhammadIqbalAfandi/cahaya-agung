<script setup>
import { computed, watchEffect } from 'vue'
import { profit, ppn as ppnUtils } from '@/utils/helpers'
import { optionStatus } from './config'
import { cartTable } from './config'
import Details from './Components/Details.vue'
import Cart from './Components/Cart.vue'
import { useCart } from './Composables/useCart'
import { useDialog } from './Composables/useDialog'
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
  status: 'success',
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
      products: cart,
    }))
    .post(route('sales.store'), {
      onSuccess: () => {
        form.reset()

        onClearCart()
      },
    })
}

watchEffect(() => {
  if (form.product?.number) {
    form.price = profit(form.product.price, form.product.profit)

    form.qty = 1
  }
})

const dropdownStatus = computed(() => {
  return optionStatus.filter((val) => val.value != 'pending')
})

const productProductUnit = computed(() => form.product?.unit)

const productProductPrice = computed(() => {
  if (form.product?.number) {
    return ppnUtils(form.product.price, form.product.ppn ? form.ppn : 0)
  }
})

const productProductPpn = computed(() => form.product?.ppn)

const productProductQty = computed(() => form.product?.qty)

const profitDescription = computed(() => {
  const priceProfit = profit(form.product?.price, form.product?.profit)

  return form.price === priceProfit ? true : false
})

const {
  cart,
  cartErrors,
  onAddCart,
  onClearCart,
  onDeleteCart,
  totalCartPrice,
} = useCart(form)

const { onShowCustomerCreate } = useDialog()
</script>

<template>
  <DashboardLayout title="Tambah Penjualan">
    <DynamicDialog />

    <div class="grid">
      <div class="col-12 md:col-8">
        <div class="grid">
          <div class="col-12">
            <Card>
              <template #title> Transaksi </template>
              <template #content>
                <div class="grid">
                  <div class="col-12 md:col-6">
                    <AppDropdown
                      label="Status"
                      placeholder="status"
                      :options="dropdownStatus"
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
                            <span>{{ slotProps.item.phone }}</span>
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
                    </AppAutoComplete>
                  </div>

                  <Divider type="dashed" />

                  <div class="col-12">
                    <h3 class="text-lg">Riwayat Pembelian Sebelumnya</h3>
                  </div>

                  <div class="col-12 md:col-6">
                    <AppInputText
                      disabled
                      label="Satuan"
                      placeholder="satuan"
                      v-model="productProductUnit"
                    />
                  </div>

                  <div class="col-12 md:col-6">
                    <AppInputNumber
                      disabled
                      class="mb-0"
                      label="Harga"
                      placeholder="harga"
                      v-model="productProductPrice"
                    />

                    <span v-if="productProductPpn" class="text-xs">
                      Harga sudah termasuk PPN {{ ppn }} %
                    </span>
                  </div>

                  <div class="col-12 md:col-6">
                    <AppInputText
                      disabled
                      label="Stok Tersedia"
                      placeholder="stok tersedia"
                      type="number"
                      v-model="productProductQty"
                    />
                  </div>

                  <Divider type="dashed" />

                  <div class="col-12 md:col-6">
                    <AppInputNumber
                      class="m-0"
                      :disabled="!form.product?.number"
                      label="Harga Jual"
                      placeholder="harga jual"
                      v-model="form.price"
                    />
                    <span v-if="profitDescription" class="text-xs">
                      Sudah termasuk profit {{ form.product.profit }} %
                    </span>
                  </div>

                  <div class="col-12 md:col-6">
                    <AppInputText
                      :disabled="!form.product?.number"
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
                    label="Tambah Produk"
                    icon="pi pi-check"
                    class="p-button-outlined"
                    :class="{ 'p-button-danger': cartErrors.length }"
                    :disabled="
                      !form.price || form.qty <= 0 || !form.product?.number
                    "
                    @click="onAddCart"
                  />
                </div>
              </template>
            </Card>
          </div>

          <div class="col-12">
            <Cart
              title="Keranjang Produk"
              :cart="cart"
              :header-table="cartTable"
              :btn-edit-show="false"
              v-model:checked-ppn="form.checkedPpn"
              @delete="onDeleteCart"
            />
          </div>
        </div>
      </div>

      <div class="col-12 md:col-4">
        <Details
          title="Detail Penjualan"
          message="Pastikan semua produk sudah benar"
          :number="number"
          :status="form.status"
          :person="form.customer"
          :product="form.product"
          :price="totalCartPrice()"
          :disabled="
            form.processing ||
            !form.status ||
            !form.customer?.id ||
            cart.length === 0
          "
          @submit="onSubmit"
        />
      </div>
    </div>
  </DashboardLayout>
</template>
