<script setup>
import { IDRCurrencyFormat } from '@/utils/currencyFormat'

defineProps({
  title: String,
  number: String,
  price: Number,
  ppn: Number,
  status: String,
  person: null,
  message: String,
  disabled: Boolean,
})
</script>

<template>
  <Card class="bg-primary">
    <template #title>
      <h2 class="text-2xl font-bold">{{ title }}</h2>
    </template>
    <template #content>
      <div class="grid">
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

            <div class="col"></div>
          </div>
        </div>

        <div v-if="person?.id" class="col-12">
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
            <div v-if="price" class="col">
              <h3 class="text-base">Total Harga</h3>
              <span>{{ IDRCurrencyFormat(price) }}</span>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template #footer>
      <div
        class="flex flex-column md:flex-row gap-2 md:gap-0 md:justify-content-between md:align-items-center"
      >
        <small>{{ message }}</small>

        <Button
          label="Simpan"
          icon="pi pi-check"
          class="p-button-outlined bg-primary-reverse"
          :disabled="disabled"
          @click="$emit('submit')"
        />
      </div>
    </template>
  </Card>
</template>
