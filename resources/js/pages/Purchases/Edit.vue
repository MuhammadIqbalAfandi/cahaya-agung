<script setup>
import { computed } from 'vue'
import { optionStatus } from './config'
import { cartTable } from './config'
import Cart from '@/pages/Components/Cart.vue'
import { useCart } from '@/pages/Composables/useCart'
import Details from './Components/Details.vue'
import { useDialog } from './Composables/useDialog'
import { useForm } from '@/composables/useForm'
import HistoryProduct from './Components/HistoryProduct.vue'
import AppInputText from '@/components/AppInputText.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import AppAutoComplete from '@/components/AppAutoComplete.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'
import { provide } from 'vue'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
  id: Number,
  number: String,
  ppn: Number,
  status: String,
  ppnChecked: Boolean,
  supplier: Object,
  products: {
    type: Array,
    default: [],
  },
  purchaseDetail: Array,
  productPurchase: Object,
})

const form = useForm({
  status: props.status,
  price: null,
  qty: null,
  supplier: props.supplier,
  product: null,
  ppn: props.ppn,
  checkedPpn: props.ppnChecked,
})

const onSubmit = () => {
  form
    .transform((data) => ({
      status: data.status,
      ppn: data.checkedPpn,
      products: [...cart, ...cartDeleted],
    }))
    .put(route('purchases.update', props.id), {
      onSuccess: () => {
        onClearCartDelete()

        Inertia.visit(route('purchases.edit', props.id), {
          only: ['purchaseDetail'],
        })
      },
    })
}

provide('form', form)

const productUnit = computed(() => form.product?.unit)

const {
  cart,
  cartDeleted,
  cartErrors,
  onClearCartDelete,
  onAddCart,
  onDeleteCart,
  totalCartPrice,
} = useCart(form, props.purchaseDetail)

const { onShowCreateProduct } = useDialog()
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
                      :options="optionStatus"
                      :error="form.errors.status"
                      v-model="form.status"
                    />
                  </div>

                  <div class="col-12 md:col-6">
                    <AppInputText
                      disabled
                      label="Supplier"
                      placeholder="supplier"
                      v-model="supplier.name"
                    />
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

                  <div v-if="form.product?.number" class="col-12 md:col-6">
                    <AppInputText
                      disabled
                      label="Satuan"
                      placeholder="satuan"
                      v-model="productUnit"
                    />
                  </div>

                  <Divider type="dashed" />

                  <HistoryProduct :product-purchase="productPurchase" />

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
