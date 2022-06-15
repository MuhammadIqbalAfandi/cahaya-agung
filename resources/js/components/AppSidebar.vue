<script setup>
import AppSubSidebar from '@/components/AppSubSidebar.vue'

defineProps({
  menu: Array,
})
</script>

<template>
  <div>
    <AppSubSidebar class="layout-menu" :items="menu" :root="true" />
  </div>
</template>

<style lang="scss" scoped>
.layout-menu {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
</style>
