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

export function removeParams(...params) {
  const urlParams = new URLSearchParams(location.search)

  params.forEach((value) => urlParams.delete(value))

  history.replaceState({}, '', `${location.pathname}?${urlParams}`)
}

export class FormValidationError extends Error {
  constructor(message, errors) {
    super(message)
    this.errors = errors
  }
}
