import { reactive } from 'vue'
import FormValidationError from '@/utils/FormValidationError'

export function useProductCart(form) {
  const cartProduct = reactive([])

  const productAddValidation = () => {
    if (form.price) {
      throw new FormValidationError('Nilai tidak boleh kosong', 'price')
    } else if (form.qty) {
      throw new FormValidationError('Nilai tidak boleh kosong', 'qty')
    } else if (form.product) {
      throw new FormValidationError('Nilai tidak boleh kosong', 'product')
    }
  }

  const onAddProduct = () => {
    try {
      form.clearErrors(['price', 'qty', 'product'])

      productAddValidation()

      cartProduct.push({
        number: form.product.number,
        name: form.product.name,
        price: form.price,
        qty: form.qty,
      })
    } catch (e) {
      form.setError(e.field, e.message)
    }
  }

  const onDeleteProduct = (index) => {
    cartProduct.splice(index)
  }

  const onClearProduct = () => {}

  return {
    cartProduct,
    onAddProduct,
    onDeleteProduct,
    onClearProduct,
  }
}
