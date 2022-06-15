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

          <AppSubSidebar :items="item.items"></AppSubSidebar>
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

          <AppSubSidebar :items="item.items"></AppSubSidebar>
        </template>
      </li>
    </template>
  </ul>
</template>

<style lang="scss" scoped>
$transition: 0.2s;

li {
  &.layout-menuitem-category {
    margin-top: 0.75rem;

    &:first-child {
      margin-top: 0;
    }
  }

  .layout-menuitem-root-text {
    text-transform: uppercase;
    color: var(--surface-900);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
  }

  a {
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    color: var(--text-color);
    transition: color $transition;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: background-color 0.15s;

    span {
      margin-left: 0.5rem;
    }

    .menuitem-toggle-icon {
      margin-left: auto;
    }

    &:focus {
      outline: 0 none;
      outline-offset: 0;
      transition: box-shadow $transition;
      box-shadow: inset var(--focus-ring);
    }

    &:hover {
      background-color: var(--surface-hover);
    }

    &.router-link-exact-active {
      font-weight: 700;
      color: var(--primary-color);
    }
  }

  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;

    ul {
      padding-left: 1rem;
    }
  }
}
</style>
