<script setup>
import { ref, computed } from 'vue'
import AppTopBar from '@/components/AppTopBar.vue'
import AppSidebar from '@/components/AppSidebar.vue'
import AppFooter from '@/components/AppFooter.vue'
import AppMessage from '@/components/AppMessage.vue'
import menu from '@/utils/menu'

const mobileMenuActive = ref(false)

const staticMenuInactive = ref(false)

const menuClick = ref(false)

const isDesktop = () => window.innerWidth >= 992

const containerClass = computed(() => {
  return [
    'layout-wrapper',
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

const onMenuToggle = (event) => {
  menuClick.value = true

  if (isDesktop()) {
    staticMenuInactive.value = !staticMenuInactive.value
  } else {
    mobileMenuActive.value = !mobileMenuActive.value
  }

  event.preventDefault()
}
</script>

<template>
  <div :class="containerClass" @click="onWrapperClick">
    <AppTopBar @menu-toggle="onMenuToggle" />

    <div class="layout-sidebar">
      <AppSidebar :menu="menu[$page.props.auth.user.role_id]" />
    </div>

    <div class="layout-main-container">
      <div class="layout-main">
        <AppMessage />

        <slot />
      </div>

      <AppFooter />
    </div>

    <Transition name="layout-mask">
      <div
        class="layout-mask p-component-overlay"
        v-if="mobileMenuActive"
      ></div>
    </Transition>
  </div>
</template>

<style lang="scss" scoped>
.layout-sidebar {
  position: fixed;
  width: 300px;
  height: calc(100vh - 9rem);
  z-index: 996;
  overflow-y: auto;
  user-select: none;
  top: 7rem;
  left: 2rem;
  transition: transform 0.2s, left 0.2s;
  background-color: var(--surface-overlay);
  border-radius: 4px;
  padding: 1.5rem;
  box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.02), 0px 0px 2px rgba(0, 0, 0, 0.05),
    0px 1px 4px rgba(0, 0, 0, 0.08);
}

.layout-main-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  justify-content: space-between;
  padding: 7rem 2rem 2rem 4rem;
  transition: margin-left 0.2s;
}

.layout-main {
  flex: 1 1 auto;
}

@media (min-width: 992px) {
  .layout-wrapper {
    .layout-main-container {
      margin-left: 300px;
    }

    &.layout-static-sidebar-inactive {
      .layout-sidebar {
        transform: translateX(-100%);
        left: 0;
      }

      .layout-main-container {
        margin-left: 0;
        padding-left: 2rem;
      }
    }

    .layout-mask {
      display: none;
    }
  }
}

@media (max-width: 991px) {
  .layout-wrapper {
    .layout-main-container {
      margin-left: 0;
      padding-left: 2rem;
    }

    .layout-sidebar {
      transform: translateX(-100%);
      left: 0;
      top: 0;
      height: 100vh;
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
    }

    .layout-mask {
      z-index: 995;
      background-color: var(--maskbg);

      &.layout-mask-enter-from,
      &.layout-mask-leave-to {
        background-color: transparent;
      }
    }

    &.layout-mobile-sidebar-active {
      .layout-sidebar {
        transform: translateX(0);
      }

      .layout-mask {
        display: block;
      }
    }
  }
}
</style>
