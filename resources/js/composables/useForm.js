import { watch, computed } from 'vue'
import { useForm as useInertiaForm, usePage } from '@inertiajs/inertia-vue3'

export function useForm(obj) {
  const form = useInertiaForm(obj)

  const errors = computed(() => usePage().props.value.errors)

  watch(errors, () => {
    form.clearErrors()
  })

  return form
}
