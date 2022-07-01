<script setup>
defineProps({
  title: String,
  headerTable: {
    required: true,
    type: Array,
  },
  value: {
    required: true,
    type: Array,
  },
})
</script>

<template>
  <DataTable
    responsiveLayout="scroll"
    columnResizeMode="expand"
    :value="value"
    :rowHover="true"
    :stripedRows="true"
  >
    <template #header>
      <h2 class="text-2xl font-bold">{{ title }}</h2>
    </template>

    <Column
      v-for="value in headerTable"
      :field="value.field"
      :header="value.header"
      :key="value.field"
    />

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
