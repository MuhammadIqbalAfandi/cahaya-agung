<script setup>
import AppMessage from '@/components/AppMessage.vue'
</script>

<template>
  <div
    class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
  >
    <div
      class="grid flex-column align-items-center p-2 lg:p-0"
      style="min-width: 80%"
    >
      <div class="col-12 xl:col-6 p-0">
        <AppMessage />
      </div>

      <div class="col-12 xl:col-6 border-gradient">
        <div class="flex flex-column m-0 p-4 bg-gradient">
          <p class="text-center mb-5 text-600 font-medium">
            <slot name="header" />
          </p>

          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.border-gradient {
  border-radius: 4px;
  padding: 0.3rem;
  background: linear-gradient(
    180deg,
    var(--primary-color),
    rgba(33, 150, 243, 0) 30%
  );
}

.bg-gradient {
  border-radius: 3px;
  background: linear-gradient(
    180deg,
    var(--surface-50) 38.9%,
    var(--surface-0)
  );
}
</style>
