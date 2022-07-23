<script setup>
import { Link } from '@inertiajs/inertia-vue3'

defineProps({
  items: Array,
  root: {
    type: Boolean,
    default: false,
  },
})
</script>

<template>
  <ul v-if="items">
    <template v-for="(item, i) of items">
      <li
        v-if="item"
        :key="i"
        :class="[{ 'layout-menuitem-category': root }]"
        role="none"
      >
        <template v-if="root">
          <div class="layout-menuitem-root-text" :aria-label="item.label">
            {{ item.label }}
          </div>

          <SubSidebar :items="item.items"></SubSidebar>
        </template>
        <template v-else>
          <Link
            v-if="item.to"
            role="menuitem"
            :href="item.to"
            :class="[
              {
                'router-link-active':
                  $page.component.startsWith(item.component) ||
                  $page.url.startsWith(item.to),
                'router-link-exact-active':
                  $page.component.startsWith(item.component) ||
                  $page.url.startsWith(item.to),
              },
            ]"
            :aria-label="item.label"
          >
            <i :class="item.icon"></i>
            <span>{{ item.label }}</span>
          </Link>

          <a v-if="!item.to" href="#" role="menuitem" :aria-label="item.label">
            <i :class="item.icon"></i>
            <span>{{ item.label }}</span>
          </a>

          <SubSidebar :items="item.items"></SubSidebar>
        </template>
      </li>
    </template>
  </ul>
</template>
