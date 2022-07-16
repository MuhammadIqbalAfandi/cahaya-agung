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
    severity="success"
    :life="3000"
    :sticky="false"
    @close="onClose"
  >
    {{ $page.props.flash.success }}
  </Message>

  <Message
    v-if="$page.props.flash.error"
    severity="error"
    :life="3000"
    :sticky="false"
    @close="onClose"
  >
    {{ $page.props.flash.error }}
  </Message>
</template>
