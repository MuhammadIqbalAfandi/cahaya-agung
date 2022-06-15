import { computed, watch } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

export function useFormErrorReset(form) {
  const errors = computed(() => usePage().props.value.errors)

  watch(errors, () => {
    form.clearErrors()
  })
}
