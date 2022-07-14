<script setup>
import { watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppInputText from '@/components/AppInputText.vue'

const props = defineProps(['product', 'supplier'])

watch(
  () => props.product,
  () => {
    if (props.product?.number && props.supplier?.id) {
      Inertia.reload({
        data: {
          productNumber: props.product.number,
          supplierId: props.supplier.id,
        },
        only: ['historyProductPurchase'],
      })
    }

    usePage().props.value.historyProductPurchase = {}
  }
)
</script>

<template>
  <template v-if="$page.props.historyProductPurchase?.id">
    <div class="col-12">
      <h3 class="text-lg">Riwayat Produk Sebelumnya</h3>
    </div>
    <div class="col-12 md:col-6">
      <AppInputNumber
        disabled
        class="mb-0"
        label="Harga"
        placeholder="harga"
        v-model="$page.props.historyProductPurchase.price"
      />

      <span v-if="$page.props.historyProductPurchase.ppn" class="text-xs">
        Harga sudah termasuk PPN {{ $page.props.ppn }} %
      </span>
    </div>

    <div class="col-12 md:col-6">
      <AppInputText
        disabled
        label="Kuantitas"
        placeholder="kuantitas"
        type="number"
        v-model="$page.props.historyProductPurchase.qty"
      />
    </div>
  </template>
</template>
