<script setup>
import AppInputText from '@/components/AppInputText.vue'
</script>

<template>
  <div class="grid">
    <div class="col-12 md:col-6">
      <AppInputText label="Nama" placeholder="nama" />
    </div>
    <div class="col-12 md:col-6">
      <AppInputText label="Alamat" placeholder="alamat" />
    </div>
    <div class="col-12 md:col-6">
      <AppInputText
        type="number"
        label="Nomor Telepon"
        placeholder="nomor telepon"
      />
    </div>
    <div class="col-12 md:col-6">
      <AppInputText label="Email" placeholder="email" />
    </div>
    <div class="col-12 md:col-6">
      <AppInputText type="number" label="NPWP" placeholder="npwp" />
    </div>
  </div>
</template>
