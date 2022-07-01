export const optionStatus = [
  {
    label: 'pending',
    value: 'pending',
  },
  {
    label: 'success',
    value: 'success',
  },
]

export const indexTable = [
  { field: 'updatedAt', header: 'Tanggal' },
  { field: 'number', header: 'Nomor Penjualan' },
  { field: 'status', header: 'Status' },
  { field: 'price', header: 'Harga' },
  { field: 'qty', header: 'Kuantitas' },
  { field: 'ppn', header: 'PPN' },
  { field: 'productName', header: 'Nama Produk' },
  { field: 'productNumber', header: 'Nomor Produk' },
]

export const cartTable = [
  { field: 'number', header: 'Nomor Produk' },
  { field: 'name', header: 'Produk' },
  { field: 'price', header: 'Harga' },
  { field: 'quantity', header: 'Kuantitas' },
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
