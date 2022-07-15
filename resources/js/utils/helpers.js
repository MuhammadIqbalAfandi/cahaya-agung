export function ppn(price, percent) {
  return price + price * (percent / 100)
}

export function profit(price, percent) {
  return ppn(price, percent)
}

export function discount(price, percent) {
  return price - price * (percent / 100)
}

export const IDRCurrencyFormat = (number, decimal = false) => {
  if (number === null) {
    return
  }

  if (decimal) {
    return 'Rp' + number.toLocaleString('id') + ',00'
  } else {
    return 'Rp' + number.toLocaleString('id')
  }
}

export class FormValidationError extends Error {
  constructor(message, errors) {
    super(message)
    this.errors = errors
  }
}
