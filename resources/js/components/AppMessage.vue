<script setup>
import { usePage } from '@inertiajs/inertia-vue3'

const onClose = () => {
  usePage().props.value.errors = {}

  usePage().props.value.flash.success = null

  usePage().props.value.flash.error = null
}
</script>

<template>
  <Message v-if="$page.props.flash.success" severity="success" @close="onClose">
    {{ $page.props.flash.success }}
  </Message>

  <Message v-if="$page.props.flash.error" severity="error" @close="onClose">
    {{ $page.props.flash.error }}
  </Message>

  <Message
    v-if="Object.keys($page.props.errors).length > 0"
    severity="error"
    @close="onClose"
  >
    <div v-if="Object.keys($page.props.errors).length === 1">
      Ditemukan satu error pada form
    </div>
    <div v-else>
      Ditemukan {{ Object.keys($page.props.errors).length }} error pada form
    </div>
  </Message>
</template>
