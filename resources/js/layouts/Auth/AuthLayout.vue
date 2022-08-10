<script setup>
import { Head } from '@inertiajs/inertia-vue3'
import AppMessage from '@/components/AppMessage.vue'

defineProps({
  title: String,
})
</script>

<template>
  <Head :title="title" />

  <div
    class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden bg-primary text-color"
  >
    <div
      class="grid flex-column align-items-center p-2 lg:p-0"
      style="min-width: 80%"
    >
      <div class="max-w-28rem p-6 m-4">
        <AppMessage />
      </div>

      <img src="/images/logo.svg" alt="logo" class="w-5rem" />

      <div class="max-w-28rem bg-white p-6 m-4 border-round-xl">
        <p class="text-center mb-5 font-bold text-3xl text-color">
          <slot name="header" />
        </p>

        <Divider align="center" />

        <slot />
      </div>
    </div>
  </div>
</template>
