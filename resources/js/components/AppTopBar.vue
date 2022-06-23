<script setup>
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
  <div class="layout-topbar">
    <Link href="/" class="layout-topbar-logo">
      <img alt="Brand Logo" src="/images/logo.svg" class="md:mr-3" />
      <span>Cahaya Agung</span>
    </Link>

    <button
      class="p-link layout-menu-button layout-topbar-button"
      @click="$emit('menu-toggle', $event)"
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
            class: 'layout-topbar-menu-tooltip',
          }"
        >
          <i class="pi pi-user"></i>
          <span>Ubah Profil</span>
        </Link>
      </li>
      <li>
        <Link
          :href="route('logout')"
          as="button"
          method="post"
          class="p-link layout-topbar-button"
          v-tooltip.bottom="{
            value: 'Keluar',
            class: 'layout-topbar-menu-tooltip',
          }"
        >
          <i class="pi pi-sign-out"></i>
          <span>Keluar</span>
        </Link>
      </li>
    </ul>
  </div>
</template>

<style lang="scss" scoped>
$transition: 0.2s;

@mixin focused() {
  outline: 0 none;
  outline-offset: 0;
  transition: box-shadow $transition;
  box-shadow: var(--focus-ring);
}

.layout-topbar {
  position: fixed;
  height: 5rem;
  z-index: 994;
  left: 0;
  top: 0;
  width: 100%;
  padding: 0 2rem;
  background-color: var(--surface-card);
  transition: left $transition;
  display: flex;
  align-items: center;
  box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.02), 0px 0px 2px rgba(0, 0, 0, 0.05),
    0px 1px 4px rgba(0, 0, 0, 0.08);

  .layout-topbar-logo {
    display: flex;
    align-items: center;
    color: var(--surface-900);
    font-size: 1.5rem;
    font-weight: 500;
    width: 300px;
    border-radius: 12px;

    img {
      height: 2.5rem;
      margin-right: 0.5rem;
    }

    &:focus {
      @include focused();
    }
  }

  .layout-topbar-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    position: relative;
    color: var(--text-color-secondary);
    border-radius: 50%;
    width: 3rem;
    height: 3rem;
    cursor: pointer;
    transition: background-color $transition;

    &:hover {
      color: var(--text-color);
      background-color: var(--surface-hover);
    }

    &:focus {
      @include focused();
    }

    i {
      font-size: 1.5rem;
    }

    span {
      font-size: 1rem;
      display: none;
    }
  }

  .layout-menu-button {
    margin-left: 2rem;
  }

  .layout-topbar-menu-button {
    display: none;

    i {
      font-size: 1.25rem;
    }
  }

  .layout-topbar-menu {
    margin: 0 0 0 auto;
    padding: 0;
    list-style: none;
    display: flex;

    .layout-topbar-button {
      margin-left: 1rem;
    }
  }
}

@media (max-width: 991px) {
  .layout-topbar {
    justify-content: space-between;

    .layout-topbar-logo {
      width: auto;
      order: 2;
    }

    .layout-menu-button {
      margin-left: 0;
      order: 1;
    }

    .layout-topbar-menu-button {
      display: inline-flex;
      margin-left: 0;
      order: 3;
    }

    .layout-topbar-menu {
      margin-left: 0;
      position: absolute;
      flex-direction: column;
      background-color: var(--surface-overlay);
      box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.02),
        0px 0px 2px rgba(0, 0, 0, 0.05), 0px 1px 4px rgba(0, 0, 0, 0.08);
      border-radius: 4px;
      padding: 1rem;
      right: 2rem;
      top: 5.5rem;
      min-width: 15rem;

      .layout-topbar-button {
        margin-left: 0;
        display: flex;
        width: 100%;
        height: auto;
        justify-content: flex-start;
        border-radius: 12px;
        padding: 1rem;

        i {
          font-size: 1rem;
          margin-right: 0.5rem;
        }

        span {
          font-weight: medium;
          display: block;
        }
      }
    }
  }
}
</style>
