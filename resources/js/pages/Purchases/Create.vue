<script setup>
import { computed, provide } from 'vue'
import { optionStatus } from './config'
import { cartTable } from './config'
import Details from './Components/Details.vue'
import Cart from './Components/Cart.vue'
import { useCart } from './Composables/useCart'
import { useDialog } from './Composables/useDialog'
import { useForm } from '@/composables/useForm'
import HistoryProduct from './Components/HistoryProduct.vue'
import AppInputText from '@/components/AppInputText.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import AppAutoComplete from '@/components/AppAutoComplete.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  number: String,
  ppn: Number,
  suppliers: {
    type: Array,
    default: [],
  },
  products: {
    type: Array,
    default: [],
  },
  productPurchase: Object,
})

const form = useForm({
  status: 'pending',
  price: null,
  qty: null,
  supplier: null,
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
      supplier_id: data.supplier.id,
      products: cart,
    }))
    .post(route('purchases.store'), {
      onSuccess: () => {
        form.reset()

        onClearCart()
      },
    })
}

provide('form', form)

const productUnit = computed(() => form.product?.unit)

const dropdownStatus = computed(() => {
  return optionStatus.filter((val) => val.value != 'success')
})

const {
  cart,
  cartErrors,
  onClearCart,
  onAddCart,
  onDeleteCart,
  totalCartPrice,
} = useCart(form)

const { onShowCreateProduct, onShowCreateSupplier } = useDialog()
</script>

<template>
  <DashboardLayout title="Tambah Pembelian">
    <DynamicDialog />

    <div class="grid">
      <div class="col-12 xl:col-8">
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
                      label="Supplier"
                      placeholder="supplier"
                      field="name"
                      param="supplier"
                      refresh-data="suppliers"
                      :error="form.errors.suppliers_id"
                      :suggestions="suppliers"
                      v-model="form.supplier"
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
                          @click="onShowCreateSupplier"
                        >
                          Tambah Supplier
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
                      empty
                      label="Produk"
                      placeholder="produk"
                      field="name"
                      param="product"
                      refresh-data="products"
                      :disabled="!form.supplier?.id"
                      :error="form.errors.product"
                      :suggestions="products"
                      v-model="form.product"
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

                  <div class="col-12 md:col-6">
                    <AppInputText
                      disabled
                      label="Satuan"
                      placeholder="satuan"
                      v-model="productUnit"
                    />
                  </div>

                  <Divider type="dashed" />

                  <HistoryProduct
                    :ppn="ppn"
                    :product-purchase="productPurchase"
                  />

                  <Divider type="dashed" />

                  <div class="col-12 md:col-6">
                    <AppInputNumber
                      label="Harga"
                      placeholder="harga"
                      :disabled="!form.product?.id"
                      v-model="form.price"
                    />
                  </div>

                  <div class="col-12 md:col-6">
                    <AppInputText
                      label="Kuantitas"
                      placeholder="kuantitas"
                      type="number"
                      :disabled="!form.product?.id"
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

      <div class="col-12 xl:col-4">
        <Details
          title="Detail Pembelian"
          message="Pastikan semua produk sudah benar"
          :number="number"
          :status="form.status"
          :person="form.supplier"
          :product="form.product"
          :price="totalCartPrice()"
          :disabled="
            form.processing ||
            !form.status ||
            !form.supplier?.id ||
            cart.length === 0
          "
          @submit="onSubmit"
        />
      </div>
    </div>
  </DashboardLayout>
</template>
