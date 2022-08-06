<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  status: Number,
})

const title = computed(() => {
  return {
    503: '503: Layanan Tidak Tersedia',
    500: '500: Server Error',
    404: '404: Halaman Tidak Ditemukan',
    403: '403: Akses Ditolak',
  }[props.status]
})

const description = computed(() => {
  return {
    503: 'Sorry, Kami sedang melakukan maintenance. Silakan periksa kembali nanti.',
    500: 'Whoops, Sesuatu sedang terjadi pada server kami.',
    404: 'Sorry, Hamalan yang anda cari tidak dapat ditemukan.',
    403: 'Sorry, Anda tidak memiliki akses kehalaman ini.',
  }[props.status]
})
</script>

<template>
  <Head :title="title" />

  <div
    class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
  >
    <div
      class="grid flex-column align-items-center p-2 lg:p-0"
      style="min-width: 80%"
    >
      <img src="/images/logo.svg" alt="logo" class="w-5rem" />

      <div class="max-w-28rem p-6 m-4">
        <div class="grid flex flex-column align-items-center">
          <div
            class="flex justify-content-center align-items-center bg-primary border-circle"
            style="height: 3.2rem; width: 3.2rem"
          >
            <i class="pi pi-fw pi-exclamation-circle text-2xl text-50"></i>
          </div>

          <h1 class="text-center mb-5 font-bold text-3xl text-color">
            {{ title }}
          </h1>

          <span class="text-center text-600">{{ description }}</span>

          <div class="col-12 mt-5 text-center">
            <i
              class="pi pi-fw pi-arrow-left text-blue-500 mr-2"
              style="vertical-align: center"
            >
            </i>
            <Link href="/" class="text-blue-500">Ayo kembali!</Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
