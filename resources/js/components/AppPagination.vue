<script setup>
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
  links: Array,
})
</script>

<template>
  <nav
    v-if="links.length > 3"
    class="p-paginator p-component flex justify-content-start"
  >
    <div class="p-paginator-pages">
      <template v-for="(link, key) in links">
        <div
          v-if="link.url === null"
          :key="`link-${key}`"
          class="p-paginator-page p-paginator-element p-link"
          :class="{ 'p-disabled': link }"
          v-html="link.label"
        />

        <Link
          v-if="link.url !== null"
          :key="`link-${key}`"
          :href="link.url"
          :class="{ 'p-highlight': link.active }"
          class="p-paginator-page p-paginator-element p-link"
          v-html="link.label"
        />
      </template>
    </div>
  </nav>
</template>
