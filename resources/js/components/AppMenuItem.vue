<script>
import Ripple from 'primevue/ripple'
import { Link } from '@inertiajs/inertia-vue3'
export default {
  name: 'Menuitem',
  inheritAttrs: false,
  components: {
    Link,
  },
  emits: ['click'],
  props: {
    item: null,
    template: null,
    exact: null,
  },
  methods: {
    onClick(event, navigate) {
      this.$emit('click', {
        originalEvent: event,
        item: this.item,
        navigate: navigate,
      })
    },
    linkClass(item) {
      return [
        'p-menuitem-link',
        {
          'p-disabled': this.disabled(item),
        },
      ]
    },
    visible() {
      return typeof this.item.visible === 'function'
        ? this.item.visible()
        : this.item.visible !== false
    },
    disabled(item) {
      return typeof item.disabled === 'function'
        ? item.disabled()
        : item.disabled
    },
    label() {
      return typeof this.item.label === 'function'
        ? this.item.label()
        : this.item.label
    },
  },
  computed: {
    containerClass() {
      return ['p-menuitem', this.item.class]
    },
  },
  directives: {
    ripple: Ripple,
  },
}
</script>

<template>
  <li :class="containerClass" role="none" :style="item.style" v-if="visible()">
    <template v-if="!template">
      <Link
        v-if="item.to && !disabled(item)"
        v-ripple
        role="menuitem"
        :href="item.to"
        :class="linkClass(item)"
        @click="onClick($event, navigate)"
      >
        <span :class="['p-menuitem-icon', item.icon]"></span>
        <span class="p-menuitem-text">{{ label() }}</span>
      </Link>
      <a
        v-else
        :href="item.url"
        :class="linkClass(item)"
        @click="onClick"
        :target="item.target"
        role="menuitem"
        :tabindex="disabled(item) ? null : '0'"
        v-ripple
      >
        <span :class="['p-menuitem-icon', item.icon]"></span>
        <span class="p-menuitem-text">{{ label() }}</span>
      </a>
    </template>
    <component v-else :is="template" :item="item"></component>
  </li>
</template>
