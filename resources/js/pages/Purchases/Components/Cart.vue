<script setup>
import { ref } from 'vue'
import { IDRCurrencyFormat } from '@/utils/currencyFormat'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppInputText from '@/components/AppInputText.vue'

defineProps({
  title: String,
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

const editingRows = ref([])
</script>

<template>
  <DataTable
    responsiveLayout="scroll"
    columnResizeMode="expand"
    edit-mode="row"
    data-key="number"
    :value="valueTable"
    :rowHover="true"
    :stripedRows="true"
    v-model:editing-rows="editingRows"
    @row-edit-save="$emit('edit', $event)"
  >
    <template #header>
      <h2 class="text-2xl font-bold">{{ title }}</h2>

      <div class="field-checkbox flex justify-content-end gap-2">
        <label class="text-sm" for="ppn">
          Semua produk dikenakan PPN {{ $page.props.ppn }}%
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
      :key="value.field"
      :field="value.field"
      :header="value.header"
    >
      <template #body="{ data, field }">
        <template v-if="field === 'price'">
          {{ IDRCurrencyFormat(data[field]) }}
        </template>

        <template v-else> {{ data[field] }} </template>
      </template>

      <template #editor="{ data, field }">
        <AppInputNumber
          v-if="field === 'price'"
          label="Harga"
          placeholder="harga"
          v-model="data[field]"
        />

        <AppInputText
          v-if="field === 'qty'"
          label="Kuantitas"
          placeholder="kuantitas"
          type="number"
          v-model="data[field]"
        />
      </template>
    </Column>

    <Column :row-editor="true" />

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
