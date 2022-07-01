<script setup>
import { useDialog } from 'primevue/usedialog'
import { optionStatus, dialogStyle } from './config'
import { cartTable } from './config'
import SupplierCreate from './Components/SupplierCreate.vue'
import ProductCreate from './Components/ProductCreate.vue'
import Details from './Components/Details.vue'
import Cart from './Components/Cart.vue'
import { useProductCart } from './Composables/useProductCart'
import { useForm } from '@/composables/useForm'
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
})

const form = useForm({
  number: props.number,
  status: 'pending',
  price: null,
  qty: null,
  supplier: null,
  product: null,
})

const onSubmit = () => {
  form
    .transform((data) => ({
      number: data.number,
      status: data.status,
      price: data.price,
      qty: data.qty,
      supplier_id: data.supplier.id,
      product_number: data.product.number,
    }))
    .post(route('purchases.store'), {
      onSuccess: () => form.reset(),
    })
}

const { cartProduct, onAddProduct, onDeleteProduct, onClearProduct } =
  useProductCart(form)

const dialog = useDialog()

const onShowCreateSupplier = () => {
  dialog.open(SupplierCreate, {
    props: {
      header: 'Tambah Supplier',
      ...dialogStyle,
    },
  })
}

const onShowCreateProduct = () => {
  dialog.open(ProductCreate, {
    props: {
      header: 'Tambah Produk',
      ...dialogStyle,
    },
  })
}
</script>

<template>
  <DashboardLayout title="Tambah Pembelian">
    <DynamicDialog />

    <div class="grid">
      <div class="col-12 md:col-8 flex-order-1 md:flex-order-0">
        <Card>
          <template #title> Pembeli </template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6">
                <AppInputText
                  disabled
                  label="Nomor Pembelian"
                  placeholder="nomor pembelian"
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
                  label="Supplier"
                  placeholder="supplier"
                  field="name"
                  refresh-data="suppliers"
                  v-model="form.supplier"
                  :error="form.errors.suppliers_id"
                  :suggestions="suppliers"
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

      <div class="col-12 md:col-4 flex-order-4 md:flex-order-0">
        <Details
          title="Detail Pembelian"
          :number="number"
          :ppn="ppn"
          :status="form.status"
          :person="form.supplier"
          :product="form.product"
          :disabled="form.processing"
          @click="onSubmit"
        />
      </div>

      <div class="col-12 md:col-8 flex-order-2 md:flex-order-0">
        <Card>
          <template #title>Produk</template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6">
                <AppAutoComplete
                  label="Produk"
                  placeholder="produk"
                  field="name"
                  refresh-data="products"
                  v-model="form.product"
                  :error="form.errors.product_number"
                  :suggestions="products"
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
                label="Tambah Produk"
                icon="pi pi-check"
                class="p-button-outlined"
                :disabled="form.processing"
                @click="onAddProduct"
              />
            </div>
          </template>
        </Card>
      </div>

      <div class="col-12 md:col-8 flex-order-3 md:flex-order-0">
        <Cart
          title="Keranjang Produk"
          :header-table="cartTable"
          :form="form"
          :value="cartProduct"
          @delete="onDeleteProduct"
        />
      </div>
    </div>
  </DashboardLayout>
</template>
