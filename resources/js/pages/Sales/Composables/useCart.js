import { reactive } from 'vue'
import { FormValidationError } from '@/utils/helpers'

export function useCart(form, initialProducts = []) {
  const cart = reactive(initialProducts)

  const cartDeleted = reactive([])

  const cartErrors = reactive([])

  const cartValidation = () => {
    onClearCartErrors()

    const itemExists = cart.find(
      (product) => product.number === form.product.number
    )

    if (Number(form.qty) + (itemExists?.qty ?? 0) > form.product.qty) {
      cartErrors.push({
        message: 'Stok tidak mencukupi',
        field: 'qty',
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

      const itemExists = cart.find(
        (product) => product.number === form.product.number
      )

      if (itemExists) {
        itemExists.qty += Number(form.qty)
      } else {
        cart.push({
          label: 'add',
          number: form.product.number,
          name: form.product.name,
          price: form.price,
          qty: Number(form.qty),
          unit: form.product.unit,
        })
      }

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
      if (form.checkedPpn) {
        return product.price + product.price * (form.ppn / 100)
      } else {
        return product.price
      }
    })

    return itemPrices.reduce(
      (prevPrice, currentPrice) => prevPrice + currentPrice,
      0
    )
  }

  return {
    cart,
    cartDeleted,
    cartErrors,
    onClearCart,
    onClearCartDelete,
    onAddCart,
    onDeleteCart,
    totalCartPrice,
  }
}
