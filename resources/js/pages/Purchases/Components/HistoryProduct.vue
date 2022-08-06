<script setup>
import { watchEffect, watch, computed, inject } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { ppn as ppnUtils } from '@/utils/helpers'
import AppInputText from '@/components/AppInputText.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'

const props = defineProps({
  ppn: Number,
  productPurchase: Object,
})

const form = inject('form')

watchEffect(() => {
  if (props.productPurchase?.number) {
    form.price = props.productPurchase.price

    form.qty = props.productPurchase.qty
  } else {
    form.price = null
  }
})

watch(
  () => form.product,
  () => {
    if (form.product?.number) {
      Inertia.reload({
        data: {
          product_number: form.product.number,
          supplier_id: form.supplier.id,
        },
        only: ['productPurchase'],
      })
    }
  }
)

const productPurchasePrice = computed(() => {
  if (props.productPurchase?.number) {
    return ppnUtils(
      props.productPurchase.price,
      props.productPurchase?.ppn ? form.ppn : 0
    )
  }
})

const productPurchasePpn = computed(() => props.productPurchase?.ppn)

const productPurchaseQty = computed(() => props.productPurchase?.qty)
</script>

<template>
  <div class="col-12">
    <h3 class="text-lg">Riwayat Produk Sebelumnya</h3>
  </div>

  <div class="col-12 md:col-6">
    <AppInputNumber
      disabled
      class="mb-0"
      label="Harga "
      placeholder="harga"
      v-model="productPurchasePrice"
    />

    <span v-if="productPurchasePpn" class="text-xs">
      Harga sudah termasuk PPN {{ ppn }} %
    </span>
  </div>

  <div class="col-12 md:col-6">
    <AppInputText
      disabled
      label="Kuantitas"
      placeholder="kuantitas"
      type="number"
      v-model="productPurchaseQty"
    />
  </div>
</template>
