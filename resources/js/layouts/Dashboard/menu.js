export default {
  // Admin
  1: [
    {
      label: 'Home',
      items: [
        {
          label: 'Dashboard',
          icon: 'pi pi-chart-bar',
          to: '/dashboards',
          component: 'Dashboards/Index',
        },
      ],
    },
    {
      label: 'Laporan',
      items: [],
    },
    {
      label: 'Master',
      items: [
        {
          label: 'User',
          icon: 'pi pi-user',
          to: '/users',
          component: 'Users/Index',
        },
      ],
    },
    {
      label: 'Pengaturan',
      items: [
        {
          label: 'PPN',
          icon: 'pi pi-percentage',
          to: '/ppn',
          component: 'PPN/Index',
        },
      ],
    },
  ],

  // Supervisor
  2: [
    {
      label: 'Home',
      items: [
        {
          label: 'Dashboard',
          icon: 'pi pi-chart-bar',
          to: '/dashboards',
          component: 'Dashboards/Index',
        },
      ],
    },
    {
      label: 'Master',
      items: [
        {
          label: 'Pelanggan',
          icon: 'pi pi-users',
          to: '/customers',
          component: 'Customers/Index',
        },
        {
          label: 'Penjualan',
          icon: 'pi pi-tag',
          to: '/sales',
          component: 'Sales/Index',
        },
        {
          label: 'Stok Barang',
          icon: 'pi pi-box',
          to: '/stock-products',
          component: 'StockProducts/Index',
        },
      ],
    },
  ],

  // Operator
  3: [
    {
      label: 'Home',
      items: [
        {
          label: 'Dashboard',
          icon: 'pi pi-chart-bar',
          to: '/dashboards',
          component: 'Dashboards/Index',
        },
      ],
    },
    {
      label: 'Master',
      items: [
        {
          label: 'Supplier',
          icon: 'pi pi-shopping-cart',
          to: '/suppliers',
          component: 'Suppliers/Index',
        },
        {
          label: 'Produk',
          icon: 'pi pi-th-large',
          to: '/products',
          component: 'Products/Index',
        },
        {
          label: 'Pembelian',
          icon: 'pi pi-shopping-cart',
          to: '/purchases',
          component: 'Purchases/Index',
        },
        {
          label: 'Stok Barang',
          icon: 'pi pi-box',
          to: '/stock-products',
          component: 'StockProducts/Index',
        },
      ],
    },
  ],
}
