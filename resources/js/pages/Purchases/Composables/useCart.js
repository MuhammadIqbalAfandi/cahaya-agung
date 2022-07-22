import { reactive } from 'vue'
import { FormValidationError, ppn } from '@/utils/helpers'

export function useCart(form, initialProducts = []) {
  const cart = reactive(initialProducts)

  const cartDeleted = reactive([])

  const cartErrors = reactive([])

  const cartValidation = () => {
    onClearCartErrors()

    const itemExists = cart.find(
      (product) => product.number === form.product.number
    )

    if (itemExists) {
      cartErrors.push({
        message: 'Produk sudah ada dikeranjang',
        field: 'product',
      })
    }

    if (cartErrors.length) {
      throw new FormValidationError('form error', cartErrors)
    }
  }

  const onAddCart = () => {
    try {
      form.clearErrors('product', 'qty')

      cartValidation()

      cart.push({
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

  const onDeleteCart = (index) => {
    if (cart[index]?.id) {
      cartDeleted.push({
        ...cart[index],
        label: 'delete',
      })
    }

    cart.splice(index, 1)
  }

  const onClearCart = () => {
    cart.splice(0)
  }

  const onClearCartDelete = () => {
    cartDeleted.splice(0)
  }

  const onClearCartErrors = () => {
    cartErrors.splice(0)
  }

  const totalCartPrice = () => {
    const itemPrices = cart.map((product) => {
      return form.checkedPpn
        ? ppn(product.price, form.ppn) * product.qty
        : product.price * product.qty
    })

    return itemPrices.reduce(
      (prevPrice, currentPrice) => prevPrice + currentPrice,
      0
    )
  }

  const onEditCart = (event) => {
    const { newData, index } = event

    cart[index] = {
      ...newData,
      label: 'edit',
    }
  }

  return {
    cart,
    cartDeleted,
    cartErrors,
    onClearCart,
    onClearCartDelete,
    onAddCart,
    onEditCart,
    onDeleteCart,
    totalCartPrice,
  }
}
