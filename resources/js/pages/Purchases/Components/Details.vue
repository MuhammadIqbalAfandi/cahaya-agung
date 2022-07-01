<script setup>
import { IDRCurrencyFormat } from '@/utils/currencyFormat'

defineProps({
  title: String,
  number: String,
  price: Number,
  qty: String,
  ppn: Number,
  status: String,
  person: Object,
  disabled: Boolean,
})
</script>

<template>
  <Card>
    <template #title>
      <h2 class="text-2xl font-bold">{{ title }}</h2>
    </template>
    <template #content>
      <div class="grid">
        <div class="col-12">
          <div class="grid">
            <div class="col">
              <h3 class="text-base">Nomor Penjualan</h3>
              <span>{{ number }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">Status Penjualan</h3>
              <span>{{ status }}</span>
            </div>

            <div class="col"></div>
          </div>
        </div>

        <div
          v-if="
            person !== null &&
            typeof person === 'object' &&
            Object.keys(person).length
          "
          class="col-12"
        >
          <div class="grid">
            <div class="col">
              <h3 class="text-base">Nama</h3>
              <span>{{ person.name }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">No Hp</h3>
              <span>{{ person.phone }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">NPWP</h3>
              <span>{{ person.npwp }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">Surel</h3>
              <span>{{ person.email }}</span>
            </div>
          </div>
        </div>

        <Divider type="dashed" />
        <div class="col-12">
          <div class="grid">
            <div class="col">
              <h3 class="text-base">Harga</h3>
              <span v-if="price">{{ IDRCurrencyFormat(price) }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">Kuantitas</h3>
              <span>{{ qty }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">PPN</h3>
              <span>{{ ppn }} %</span>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template #footer>
      <div class="flex flex-column md:flex-row justify-content-end">
        <Button
          label="Simpan"
          icon="pi pi-check"
          class="p-button-outlined"
          :disabled="disabled"
          @click="$emit('click')"
        />
      </div>
    </template>
  </Card>
</template>
