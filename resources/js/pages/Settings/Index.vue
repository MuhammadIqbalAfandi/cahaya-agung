<script setup>
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'
import Ppn from './Components/Ppn.vue'
import CompanyProfile from './Components/CompanyProfile.vue'

defineProps({
  ppn: Number,
})
</script>

<template>
  <DashboardLayout title="Pengaturan">
    <div class="grid">
      <div class="col-12 md:col-8">
        <Card>
          <template #title> Pengaturan </template>
          <template #content>
            <CompanyProfile />

            <divider />

            <Ppn :ppn="ppn" />
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
