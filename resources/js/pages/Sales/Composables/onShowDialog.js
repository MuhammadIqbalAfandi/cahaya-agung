import { useDialog } from 'primevue/usedialog'
import CustomerCreate from '../Components/CustomerCreate.vue'

export function onShowDialog() {
  const dialog = useDialog()

  const dialogStyle = {
    style: {
      width: '50vw',
    },
    breakpoints: {
      '960px': '75vw',
      '640px': '90vw',
    },
    modal: true,
  }

  const onShowCustomerCreate = () => {
    dialog.open(CustomerCreate, {
      props: {
        header: 'Tambah Pelanggan',
        ...dialogStyle,
      },
    })
  }

  return {
    onShowCustomerCreate,
  }
}
