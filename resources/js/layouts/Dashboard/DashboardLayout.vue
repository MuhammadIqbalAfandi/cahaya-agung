<script setup>
import { ref, computed } from 'vue'
import { Head } from '@inertiajs/inertia-vue3'
import menu from './menu'
import AppMessage from '@/components/AppMessage.vue'
import TopBar from './Components/TopBar.vue'
import Sidebar from './Components/Sidebar.vue'
import Footer from './Components/Footer.vue'

defineProps({
  title: String,
})

const mobileMenuActive = ref(false)

const staticMenuInactive = ref(false)

const menuClick = ref(false)

const isDesktop = () => window.innerWidth >= 992

const containerClass = computed(() => {
  return [
    'layout-wrapper',
    'layout-static',
    {
      'layout-static-sidebar-inactive': staticMenuInactive.value,
      'layout-mobile-sidebar-active': mobileMenuActive.value,
    },
  ]
})

const onWrapperClick = () => {
  if (!menuClick.value) {
    mobileMenuActive.value = false
  }

  menuClick.value = false
}

const onMenuToggle = () => {
  menuClick.value = true

  if (isDesktop()) {
    staticMenuInactive.value = !staticMenuInactive.value
  } else {
    mobileMenuActive.value = !mobileMenuActive.value
  }
}
</script>

<template>
  <Head :title="title" />

  <ConfirmDialog />

  <div :class="containerClass" @click="onWrapperClick">
    <TopBar @menu-toggle="onMenuToggle" />

    <nav class="layout-sidebar">
      <Sidebar :menu="menu[$page.props.auth.user.role_id]" />
    </nav>

    <div class="layout-main-container">
      <main class="layout-main">
        <AppMessage />

        <slot />
      </main>

      <Footer />
    </div>

    <Transition name="layout-mask">
      <div
        class="layout-mask p-component-overlay"
        v-if="mobileMenuActive"
      ></div>
    </Transition>
  </div>
</template>
