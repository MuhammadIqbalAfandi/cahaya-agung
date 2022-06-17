<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
  status: null,
})

const title = computed(() => {
  return {
    503: '503: Service Unavailable',
    500: '500: Server Error',
    404: '404: Page Not Found',
    403: '403: Forbidden',
  }[props.status]
})

const description = computed(() => {
  return {
    503: 'Sorry, we are doing some maintenance. Please check back soon.',
    500: 'Whoops, something went wrong on our servers.',
    404: 'Sorry, the page you are looking for could not be found.',
    403: 'Sorry, you are forbidden from accessing this page.',
  }[props.status]
})
</script>

<template>
  <Head :title="title" />

  <div
    class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
  >
    <div class="grid justify-content-center p-2 lg:p-0" style="min-width: 80%">
      <div class="col-12 mt-5 xl:mt-0 text-center">
        <img
          src="/images/logo.svg"
          alt="Brand Logo"
          class="mb-5"
          style="width: 81px; height: 60px"
        />
      </div>
      <div class="col-12 xl:col-6 border-gradient">
        <div class="h-full w-full m-0 py-7 px-4 bg-gradient">
          <div class="grid flex flex-column align-items-center">
            <div
              class="flex justify-content-center align-items-center bg-pink-500 border-circle"
              style="height: 3.2rem; width: 3.2rem"
            >
              <i class="pi pi-fw pi-exclamation-circle text-2xl text-50"></i>
            </div>
            <h1 class="font-bold text-5xl text-900 mb-2">{{ title }}</h1>
            <span class="text-600">{{ description }}</span>
            <div class="col-12 mt-5 text-center">
              <i
                class="pi pi-fw pi-arrow-left text-blue-500 mr-2"
                style="vertical-align: center"
              ></i>
              <Link href="/" class="text-blue-500">Kembali ke Dashboard</Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.border-gradient {
  border-radius: 4px;
  padding: 0.3rem;
  background: linear-gradient(
    180deg,
    rgba(233, 30, 99, 0.4) 10%,
    rgba(33, 150, 243, 0) 30%
  );
}
.bg-gradient {
  border-radius: 3px;
  background: linear-gradient(
    180deg,
    var(--surface-50) 38.9%,
    var(--surface-0)
  );
}
</style>
