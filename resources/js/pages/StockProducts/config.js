export const indexTable = [
  { field: 'updatedAt', header: 'Terakhir Diperbaharui' },
  { field: 'productNumber', header: 'Nomor Produk' },
  { field: 'name', header: 'Nama Produk' },
  { field: 'price', header: 'Harga' },
  { field: 'qty', header: 'Kuantitas' },
  { field: 'unit', header: 'Satuan' },
]

export const detailTable = [
  { field: 'createdAt', header: 'Tanggal' },
  { field: 'name', header: 'Nama Produk' },
  { field: 'price', header: 'Harga' },
  { field: 'qty', header: 'Kuantitas' },
  { field: 'ppn', header: 'PPN' },
  { field: 'unit', header: 'Satuan' },
]

export const stockOptionCategory = [
  null,
  {
    label: 'Kuantitas lebih dari satu',
    value: 'not null',
  },
]

export const filterOptionCategory = [
  null,
  {
    label: 'Penambahan Stok',
    value: 'PBN',
  },
  {
    label: 'Pengurangan Stok',
    value: 'PJN',
  },
]
