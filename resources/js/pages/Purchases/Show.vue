<script setup>
import { useForm } from '@/composables/useForm'
import { IDRCurrencyFormat } from '@/utils/helpers'
import { cartTable } from './config'
import Cart from './Components/Cart.vue'
import { useProductCart } from './Composables/useProductCart'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  number: String,
  ppn: Number,
  status: String,
  ppnChecked: Boolean,
  supplier: Object,
  purchaseDetail: Array,
})

const form = useForm({
  status: props.status,
  supplier: props.supplier,
  ppn: props.ppn,
  checkedPpn: props.ppnChecked,
})

const { productCart, totalProductPrice } = useProductCart(
  form,
  props.purchaseDetail
)
</script>

<template>
  <DashboardLayout title="Lihat Pembelian">
    <DynamicDialog />

    <div class="grid">
      <div class="col-12 md:col-8">
        <div class="grid">
          <div class="col-12">
            <Card>
              <template #title>
                <h2 class="text-2xl font-bold">Detail Pembelian</h2>
              </template>
              <template #content>
                <div class="grid">
                  <div class="col-12">
                    <div class="grid">
                      <div class="col">
                        <h3 class="text-base">Nama</h3>
                        <span>{{ supplier.name }}</span>
                      </div>
                      <div class="col">
                        <h3 class="text-base">Alamat</h3>
                        <span>{{ supplier.address }}</span>
                      </div>
                      <div class="col">
                        <h3 class="text-base">No HP</h3>
                        <span>{{ supplier.phone }}</span>
                      </div>
                      <div class="col">
                        <h3 class="text-base">NPWP</h3>
                        <span>{{ supplier.npwp }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="grid">
                      <div class="col">
                        <h3 class="text-base">Nomor Pembelian</h3>
                        <span>{{ number }}</span>
                      </div>
                      <div class="col">
                        <h3 class="text-base">Status Pembelian</h3>
                        <span>{{ status }}</span>
                      </div>
                      <div class="col">
                        <h3 class="text-base">Total Harga</h3>
                        <span>{{
                          IDRCurrencyFormat(totalProductPrice())
                        }}</span>
                      </div>
                      <div class="col"></div>
                    </div>
                  </div>
                </div>
              </template>
            </Card>
          </div>
          <div class="col-12">
            <Cart
              title="Keranjang Produk"
              :product-cart="productCart"
              :header-table="cartTable"
              :btn-ppn-disabled="true"
              :btn-delete-show="false"
              :btn-edit-show="false"
              v-model:checked-ppn="form.checkedPpn"
            />
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
