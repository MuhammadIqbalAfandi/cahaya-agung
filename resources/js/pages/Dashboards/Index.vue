<script setup>
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const lineData = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
  datasets: [
    {
      label: 'Pembelian',
      data: [65, 59, 80, 81, 56, 55, 40],
      fill: false,
      backgroundColor: '#2f4860',
      borderColor: '#2f4860',
      tension: 0.4,
    },
    {
      label: 'Penjualan',
      data: [28, 48, 40, 19, 86, 27, 90],
      fill: false,
      backgroundColor: '#00bb7e',
      borderColor: '#00bb7e',
      tension: 0.4,
    },
  ],
}

const barData = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
  datasets: [
    {
      label: 'Bulan lalu',
      data: [
        65_000_000, 59_000_000, 80_000_000, 81_000_000, 56_000_000, 55_000_000,
        40_000_000,
      ],
      fill: false,
      backgroundColor: '#2f4860',
      borderColor: '#2f4860',
      tension: 0.4,
    },
    {
      label: 'Bulan ini',
      data: [
        28_000_000, 48_000_000, 40_000_000, 19_000_000, 86_000_000, 27_000_000,
        90_000_000,
      ],
      fill: false,
      backgroundColor: '#00bb7e',
      borderColor: '#00bb7e',
      tension: 0.4,
    },
  ],
}

const lineOptions = null
</script>

<template>
  <DashboardLayout title="Dashboard">
    <div class="grid">
      <div class="col-12">
        <div class="grid">
          <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
              <div class="flex justify-content-between mb-3">
                <div>
                  <span class="block text-500 font-medium mb-3">Produk</span>
                  <div class="text-900 font-medium text-xl">152</div>
                </div>
                <div
                  class="flex align-items-center justify-content-center bg-blue-100 border-round"
                  style="width: 2.5rem; height: 2.5rem"
                >
                  <i class="pi pi-th-large text-blue-500 text-xl"></i>
                </div>
              </div>
              <span class="text-green-500 font-medium">24 produk </span>
              <span class="text-500">hari ini</span>
            </div>
          </div>

          <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
              <div class="flex justify-content-between mb-3">
                <div>
                  <span class="block text-500 font-medium mb-3">Pembelian</span>
                  <div class="text-900 font-medium text-xl">284</div>
                </div>
                <div
                  class="flex align-items-center justify-content-center bg-yellow-100 border-round"
                  style="width: 2.5rem; height: 2.5rem"
                >
                  <i class="pi pi-shopping-cart text-yellow-500 text-xl"></i>
                </div>
              </div>
              <span class="text-green-500 font-medium">28 pembelian </span>
              <span class="text-500">hari ini</span>
            </div>
          </div>

          <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
              <div class="flex justify-content-between mb-3">
                <div>
                  <span class="block text-500 font-medium mb-3">Penjualan</span>
                  <div class="text-900 font-medium text-xl">284</div>
                </div>
                <div
                  class="flex align-items-center justify-content-center bg-purple-100 border-round"
                  style="width: 2.5rem; height: 2.5rem"
                >
                  <i class="pi pi-shopping-cart text-purple-500 text-xl"></i>
                </div>
              </div>
              <span class="text-green-500 font-medium">8 penjualan </span>
              <span class="text-500">hari ini</span>
            </div>
          </div>

          <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0">
              <div class="flex justify-content-between mb-3">
                <div>
                  <span class="block text-500 font-medium mb-3"
                    >Stok Barang</span
                  >
                  <div class="text-900 font-medium text-xl">2848</div>
                </div>
                <div
                  class="flex align-items-center justify-content-center bg-orange-100 border-round"
                  style="width: 2.5rem; height: 2.5rem"
                >
                  <i class="pi pi-box text-orange-500 text-xl"></i>
                </div>
              </div>
              <span class="text-green-500 font-medium">0 barang baru </span>
              <span class="text-500">hari ini</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 xl:col-6">
        <div class="grid">
          <div class="col-12">
            <div class="card">
              <h5>Pembelian dan Penjualan</h5>
              <Chart type="line" :data="lineData" :options="lineOptions" />
            </div>
          </div>

          <div class="col-12">
            <div class="card">
              <div class="flex justify-content-between align-items-center mb-5">
                <h5>Produk Terlaris</h5>
              </div>
              <ul class="list-none p-0 m-0">
                <li
                  class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
                >
                  <div>
                    <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                      >Space T-Shirt</span
                    >
                    <div class="mt-1 text-600">Clothing</div>
                  </div>
                  <div class="mt-2 md:mt-0 flex align-items-center">
                    <div
                      class="surface-300 border-round overflow-hidden w-10rem lg:w-6rem"
                      style="height: 8px"
                    >
                      <div
                        class="bg-orange-500 h-full"
                        style="width: 50%"
                      ></div>
                    </div>
                    <span class="text-orange-500 ml-3 font-medium">%50</span>
                  </div>
                </li>
                <li
                  class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
                >
                  <div>
                    <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                      >Portal Sticker</span
                    >
                    <div class="mt-1 text-600">Accessories</div>
                  </div>
                  <div
                    class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center"
                  >
                    <div
                      class="surface-300 border-round overflow-hidden w-10rem lg:w-6rem"
                      style="height: 8px"
                    >
                      <div class="bg-cyan-500 h-full" style="width: 16%"></div>
                    </div>
                    <span class="text-cyan-500 ml-3 font-medium">%16</span>
                  </div>
                </li>
                <li
                  class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
                >
                  <div>
                    <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                      >Supernova Sticker</span
                    >
                    <div class="mt-1 text-600">Accessories</div>
                  </div>
                  <div
                    class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center"
                  >
                    <div
                      class="surface-300 border-round overflow-hidden w-10rem lg:w-6rem"
                      style="height: 8px"
                    >
                      <div class="bg-pink-500 h-full" style="width: 67%"></div>
                    </div>
                    <span class="text-pink-500 ml-3 font-medium">%67</span>
                  </div>
                </li>
                <li
                  class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
                >
                  <div>
                    <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                      >Wonders Notebook</span
                    >
                    <div class="mt-1 text-600">Office</div>
                  </div>
                  <div
                    class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center"
                  >
                    <div
                      class="surface-300 border-round overflow-hidden w-10rem lg:w-6rem"
                      style="height: 8px"
                    >
                      <div class="bg-green-500 h-full" style="width: 35%"></div>
                    </div>
                    <span class="text-green-500 ml-3 font-medium">%35</span>
                  </div>
                </li>
                <li
                  class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
                >
                  <div>
                    <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                      >Mat Black Case</span
                    >
                    <div class="mt-1 text-600">Accessories</div>
                  </div>
                  <div
                    class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center"
                  >
                    <div
                      class="surface-300 border-round overflow-hidden w-10rem lg:w-6rem"
                      style="height: 8px"
                    >
                      <div
                        class="bg-purple-500 h-full"
                        style="width: 75%"
                      ></div>
                    </div>
                    <span class="text-purple-500 ml-3 font-medium">%75</span>
                  </div>
                </li>
                <li
                  class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
                >
                  <div>
                    <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                      >Robots T-Shirt</span
                    >
                    <div class="mt-1 text-600">Clothing</div>
                  </div>
                  <div
                    class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center"
                  >
                    <div
                      class="surface-300 border-round overflow-hidden w-10rem lg:w-6rem"
                      style="height: 8px"
                    >
                      <div class="bg-teal-500 h-full" style="width: 40%"></div>
                    </div>
                    <span class="text-teal-500 ml-3 font-medium">%40</span>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 xl:col-6">
        <div class="grid">
          <div class="col-12">
            <div class="card">
              <h5>Pembelian</h5>
              <Chart type="bar" :data="barData" :options="lineOptions" />
            </div>
          </div>

          <div class="col-12">
            <div class="card">
              <h5>Pendapatan</h5>
              <Chart type="bar" :data="barData" :options="lineOptions" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
