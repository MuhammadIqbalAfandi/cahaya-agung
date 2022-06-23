import { Inertia } from '@inertiajs/inertia'
import { useDialog } from 'primevue/usedialog'
import { dialogStyle } from './config'
import ProductCreate from './Components/Dialog/ProductCreate.vue'

export function useProductAutoComplete(form) {
  const dialog = useDialog()

  const productOnComplete = (event) => {
    Inertia.reload({
      data: { product: event.query },
      only: ['products'],
    })
  }

  const productOnSelected = (event) => {
    form.product = event.value
  }

  const showCreateProduct = () => {
    dialog.open(ProductCreate, {
      props: {
        header: 'Tambah Produk',
        ...dialogStyle,
      },
    })
  }

  return {
    productOnComplete,
    productOnSelected,
    showCreateProduct,
  }
}
