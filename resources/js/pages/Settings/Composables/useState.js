import { reactive } from 'vue'

export function useState() {
  const state = reactive({
    disable: true,
    label: 'Ubah',
    icon: 'pi pi-pencil',
  })

  function setState() {
    if (state.disable) {
      state.label = 'Simpan'

      state.icon = 'pi pi-check'

      state.disable = false
    } else {
      state.label = 'Ubah'

      state.icon = 'pi pi-pencil'

      state.disable = true
    }
  }

  return {
    state,
    setState,
  }
}
