import { useDialog as usePrimeDialog } from 'primevue/usedialog'
import SupplierCreate from '../Components/SupplierCreate.vue'
import ProductCreate from '../Components/ProductCreate.vue'

export function useDialog() {
  const dialog = usePrimeDialog()

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

  const onShowCreateSupplier = () => {
    dialog.open(SupplierCreate, {
      props: {
        header: 'Tambah Supplier',
        ...dialogStyle,
      },
    })
  }

  const onShowCreateProduct = () => {
    dialog.open(ProductCreate, {
      props: {
        header: 'Tambah Produk',
        ...dialogStyle,
      },
    })
  }

  return {
    onShowCreateProduct,
    onShowCreateSupplier,
  }
}
