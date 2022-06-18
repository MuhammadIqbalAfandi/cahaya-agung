<script setup>
import { Inertia } from '@inertiajs/inertia'
import { useForm, Head } from '@inertiajs/inertia-vue3'
import { useFormErrorReset } from '@/components/useFormErrorReset'
import { useDialog } from 'primevue/usedialog'
import AppInputText from '@/components/AppInputText.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import AppAutocompleteBasic from '@/components/AppAutocompleteBasic.vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'
import CustomerCreate from '@/pages/Customers/Components/Create.vue'
import ProductCreate from '@/pages/Products/Components/Create.vue'

const props = defineProps({
  number: String,
  productNumber: String,
  customers: {
    type: Array,
    default: [],
  },
  products: {
    type: Array,
    default: [],
  },
})

const dialog = useDialog()
const dialogStyle = {
  style: {
    width: '50vw',
  },
  breakpoints: {
    '960px': '75vw',
    '640px': '90vw',
  },
  modal: true,
}

const form = useForm({
  number: props.number,
  status: 'pending',
  price: null,
  qty: null,
  customer_id: null,
  product_id: null,
})

useFormErrorReset(form)

const optionStatus = [
  {
    label: 'Pending',
    value: 'pending',
  },
  {
    label: 'Berhasil',
    value: 'success',
  },
]

const customerOnComplete = (event) => {
  Inertia.reload({
    data: { customer: event.query },
    only: ['customers'],
  })
}

const customerOnSelected = (event) => {
  form.customer_id = event.value
}

const showCreateCustomer = () => {
  dialog.open(CustomerCreate, {
    props: {
      header: 'Tambah Pelanggan',
      ...dialogStyle,
    },
  })
}

const productOnComplete = (event) => {
  Inertia.reload({
    data: { product: event.query },
    only: ['products'],
  })
}

const productOnSelected = (event) => {
  form.product_id = event.value
}

const showCreateProduct = () => {
  dialog.open(ProductCreate, {
    props: {
      header: 'Tambah Produk',
      ...dialogStyle,
    },
  })
}

const onSubmit = () => {
  form
    .transform((data) => ({
      ...data,
      customer_id: data.customer_id.id,
      product_id: data.product_id.id,
    }))
    .post(route('sales.store'), { onSuccess: () => form.reset() })
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
                <AppAutocompleteBasic
                  label="Pelanggan"
                  placeholder="pelanggan"
                  field="name"
                  v-model="form.customer_id"
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
                </AppAutocompleteBasic>
              </div>

              <div class="col-12 md:col-6">
                <AppAutocompleteBasic
                  label="Produk"
                  placeholder="produk"
                  field="name"
                  v-model="form.product_id"
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
                </AppAutocompleteBasic>
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
    </div>
  </DashboardLayout>
</template>
