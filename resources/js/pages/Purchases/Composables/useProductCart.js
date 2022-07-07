import FormValidationError from '@/utils/FormValidationError'
import { reactive } from 'vue'

export function useProductCart(form, initialProducts = []) {
  const productCart = reactive(initialProducts)

  const productValidation = () => {
    const existProduct = productCart.find(
      (product) => product.number === form.product.number
    )

    if (existProduct) {
      throw new FormValidationError('Produk sudah ada dikeranjang', 'product')
    }
  }

  const onAddProduct = () => {
    try {
      form.clearErrors('product', 'price', 'qty')

      productValidation()

      productCart.push({
        number: form.product.number,
        name: form.product.name,
        price: form.price,
        qty: form.qty,
        unit: form.product.unit,
      })

      form.reset('product', 'price', 'qty')
    } catch (e) {
      form.setError(e.field, e.message)
    }
  }

  const onDeleteProduct = (index) => {
    productCart.splice(index, 1)
  }

  const onClearProduct = () => {
    productCart.splice(0)
  }

  const totalProductPrice = () => {
    const productPrices = productCart.map((product) => {
      if (form.checkedPpn) {
        return product.price + product.price * (form.ppn / 100)
      } else {
        return product.price
      }
    })

    return productPrices.reduce((prev, current) => prev + current, 0)
  }

  const onEditProduct = (event) => {
    const { newData, index } = event

    productCart[index] = newData
  }

  return {
    productCart,
    onAddProduct,
    onDeleteProduct,
    onEditProduct,
    onClearProduct,
    totalProductPrice,
  }
}
