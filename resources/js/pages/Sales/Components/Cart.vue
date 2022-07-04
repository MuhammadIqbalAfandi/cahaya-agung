<script setup>
import { IDRCurrencyFormat } from '@/utils/currencyFormat'

defineProps({
  title: String,
  ppn: {
    required: true,
    type: Number,
  },
  headerTable: {
    required: true,
    type: Array,
  },
  valueTable: {
    required: true,
    type: Array,
  },
  checkedPpn: Boolean,
})
</script>

<template>
  <DataTable
    responsiveLayout="scroll"
    columnResizeMode="expand"
    :value="valueTable"
    :rowHover="true"
    :stripedRows="true"
  >
    <template #header>
      <h2 class="text-2xl font-bold">{{ title }}</h2>

      <div class="field-checkbox flex justify-content-end gap-2">
        <label class="text-sm" for="ppn">
          Semua produk dikenakan PPN {{ ppn }}%
        </label>
        <input
          type="checkbox"
          id="ppn"
          :checked="checkedPpn"
          @input="$emit('update:checkedPpn', $event.target.checked)"
        />
      </div>
    </template>

    <Column
      v-for="value in headerTable"
      :field="value.field"
      :header="value.header"
      :key="value.field"
    >
      <template #body="{ data, field }">
        <template v-if="field === 'price'">
          {{ IDRCurrencyFormat(data[field]) }}
        </template>

        <template v-else> {{ data[field] }} </template>
      </template>
    </Column>

    <Column>
      <template #body="{ index }">
        <Button
          icon="pi pi-trash"
          class="p-button-icon-only p-button-rounded p-button-text"
          v-tooltip.bottom="'hapus'"
          @click="$emit('delete', index)"
        />
      </template>
    </Column>
  </DataTable>
</template>
