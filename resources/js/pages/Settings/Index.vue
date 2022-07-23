<script setup>
import CompanyProfile from './Components/CompanyProfile.vue'
import Ppn from './Components/Ppn.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

defineProps({
  ppn: Object,
  company: Object,
})
</script>

<template>
  <DashboardLayout title="Pengaturan">
    <div class="grid">
      <div class="col-12">
        <Card>
          <template #title> Pengaturan </template>
          <template #content>
            <CompanyProfile :company="company" />

            <Divider />

            <Ppn :ppn="ppn" />
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
