import { watch } from 'vue'
import { useForm as useInertiaForm } from '@inertiajs/inertia-vue3'

export function useForm(obj) {
  const form = useInertiaForm(obj)

  for (const key in obj) {
    watch(
      () => form[key],
      (newVal, oldVal) => {
        if (newVal != oldVal) {
          form.clearErrors(key)
        }
      }
    )
  }

  return form
}
