import { Inertia } from '@inertiajs/inertia'
import { useDialog } from 'primevue/usedialog'
import { dialogStyle } from './config'
import CustomerCreate from './Components/Dialog/CustomerCreate.vue'

export function useCustomerAutoComplete(form) {
  const dialog = useDialog()

  const customerOnComplete = (event) => {
    Inertia.reload({
      data: { customer: event.query },
      only: ['customers'],
    })
  }

  const customerOnSelected = (event) => {
    form.customer = event.value
  }

  const showCreateCustomer = () => {
    dialog.open(CustomerCreate, {
      props: {
        header: 'Tambah Pelanggan',
        ...dialogStyle,
      },
    })
  }

  return {
    customerOnComplete,
    customerOnSelected,
    showCreateCustomer,
  }
}
