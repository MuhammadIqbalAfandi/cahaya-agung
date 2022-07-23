<script setup>
import SubSidebar from './SubSidebar.vue'

defineProps({
  menu: Array,
})
</script>

<template>
  <div>
    <SubSidebar class="layout-menu" :items="menu" :root="true" />
  </div>
</template>
