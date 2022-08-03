<script setup>
import { usePage } from '@inertiajs/inertia-vue3'

const onClose = () => {
  usePage().props.value.flash.success = null

  usePage().props.value.flash.error = null
}
</script>

<template>
  <Message
    v-if="$page.props.flash.success"
    class="mt-0"
    severity="success"
    @close="onClose"
  >
    {{ $page.props.flash.success }}
  </Message>

  <Message
    v-if="$page.props.flash.error"
    class="mt-0"
    severity="error"
    @close="onClose"
  >
    {{ $page.props.flash.error }}
  </Message>
</template>
