export const optionStatus = [
  {
    label: 'Pending',
    value: 'pending',
  },
  {
    label: 'Success',
    value: 'success',
  },
]

export const indexTable = [
  { field: 'updatedAt', header: 'Tanggal' },
  { field: 'number', header: 'Nomor Penjualan' },
  { field: 'status', header: 'Status' },
  { field: 'price', header: 'Harga' },
  { field: 'qty', header: 'Kuantitas' },
  { field: 'productName', header: 'Nama Produk' },
  { field: 'productNumber', header: 'Nomor Produk' },
]

export const dialogStyle = {
  style: {
    width: '50vw',
  },
  breakpoints: {
    '960px': '75vw',
    '640px': '90vw',
  },
  modal: true,
}
