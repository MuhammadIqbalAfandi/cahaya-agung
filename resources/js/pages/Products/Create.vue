<script setup>
import { Head } from '@inertiajs/inertia-vue3'
import Create from './Components/Create.vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'

defineProps({
  number: String,
})
</script>

<template>
  <Head title="Tambah Produk" />

  <DashboardLayout>
    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Tambah Produk </template>
          <template #content>
            <Create :number="number" />
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
