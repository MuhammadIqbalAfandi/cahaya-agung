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
