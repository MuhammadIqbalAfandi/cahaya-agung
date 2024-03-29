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

export const filterOptionStatus = [
  null,
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
  { field: 'name', header: 'Nama Supplier' },
  { field: 'phone', header: 'No HP Supplier' },
  { field: 'email', header: 'Email Supplier' },
  { field: 'price', header: 'Total Harga' },
  { field: 'status', header: 'Status' },
]

export const cartTable = [
  { field: 'number', header: 'Nomor Produk' },
  { field: 'name', header: 'Produk' },
  { field: 'price', header: 'Harga' },
  { field: 'qty', header: 'Kuantitas' },
  { field: 'unit', header: 'Satuan' },
]

export const reportTable = [
  { field: 'updatedAt', header: 'Tanggal' },
  { field: 'totalPrice', header: 'Total Harga' },
  { field: 'qty', header: 'Kuantitas' },
  { field: 'status', header: 'Status' },
]
