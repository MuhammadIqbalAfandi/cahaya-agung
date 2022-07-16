import { reactive } from 'vue'
import { FormValidationError } from '@/utils/helpers'

export function useProductCart(form, initialProducts = []) {
  const productCart = reactive(initialProducts)

  const productCartDeleted = reactive([])

  const productErrors = reactive([])

  const productValidation = () => {
    onClearProductErrors()

    const productExists = productCart.find(
      (product) => product.number === form.product.number
    )

    if (productExists) {
      productErrors.push({
        message: 'Produk sudah ada dikeranjang',
        field: 'product',
      })
    }

    if (productErrors.length) {
      throw new FormValidationError('form error', productErrors)
    }
  }

  const onAddProduct = () => {
    try {
      form.clearErrors('product', 'qty')

      productValidation()

      productCart.push({
        label: 'add',
        number: form.product.number,
        name: form.product.name,
        price: form.price,
        qty: Number(form.qty),
        unit: form.product.unit,
      })

      form.reset('product', 'price', 'qty')
    } catch (e) {
      e.errors.forEach((error) => {
        form.setError(error.field, error.message)
      })
    }
  }

  const onDeleteProduct = (index) => {
    if (productCart[index]?.id) {
      productCartDeleted.push({
        ...productCart[index],
        label: 'delete',
      })
    }

    productCart.splice(index, 1)
  }

  const onClearProductCart = () => {
    productCart.splice(0)
  }

  const onClearProductCartDelete = () => {
    productCartDeleted.splice(0)
  }

  const onClearProductErrors = () => {
    productErrors.splice(0)
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

    productCart[index] = {
      ...newData,
      label: 'edit',
    }
  }

  return {
    productCart,
    productCartDeleted,
    productErrors,
    onClearProductCart,
    onClearProductCartDelete,
    onAddProduct,
    onDeleteProduct,
    onEditProduct,
    totalProductPrice,
  }
}
