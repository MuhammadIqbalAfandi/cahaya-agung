<script setup>
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3'
import { useConfirm } from 'primevue/useconfirm'

const logoutConfirm = useConfirm()

const logout = () => {
  logoutConfirm.require({
    message: 'Ingin keluar dari aplikasi',
    header: 'Keluar',
    acceptLabel: 'Iya',
    rejectLabel: 'Tidak',
    accept: () => {
      Inertia.post(route('logout'))
    },
    reject: () => {
      logoutConfirm.close()
    },
  })
}
</script>

<template>
  <div class="layout-topbar">
    <Link href="/" class="layout-topbar-logo">
      <img alt="Brand Logo" src="/images/logo.svg" />
      <span>{{ $page.props.company?.name ?? 'Your Company' }}</span>
    </Link>

    <button
      class="p-link layout-menu-button layout-topbar-button"
      @click="$emit('menu-toggle')"
    >
      <i class="pi pi-bars"></i>
    </button>

    <button
      class="p-link layout-topbar-menu-button layout-topbar-button"
      v-styleclass="{
        selector: '@next',
        enterClass: 'hidden',
        enterActiveClass: 'scalein',
        leaveToClass: 'hidden',
        leaveActiveClass: 'fadeout',
        hideOnOutsideClick: true,
      }"
    >
      <i class="pi pi-ellipsis-v"></i>
    </button>

    <ul class="layout-topbar-menu hidden lg:flex origin-top">
      <li class="align-self-center">
        <span class="hidden lg:inline">{{ $page.props.auth.user.name }}</span>
      </li>
      <li>
        <Link
          :href="route('users.show', $page.props.auth.user.id)"
          class="p-link layout-topbar-button"
          v-tooltip.bottom="{
            value: 'Ubah Profil',
          }"
        >
          <i class="pi pi-user"></i>
          <span>Ubah Profil</span>
        </Link>
      </li>
      <li>
        <button
          class="p-link layout-topbar-button"
          v-tooltip.bottom="{
            value: 'Keluar',
          }"
          @click="logout"
        >
          <i class="pi pi-sign-out"></i>
          <span>Keluar</span>
        </button>
      </li>
    </ul>
  </div>
</template>
