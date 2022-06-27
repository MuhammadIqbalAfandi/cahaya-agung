<script setup>
defineProps([
  'saleNumber',
  'salePrice',
  'saleQty',
  'salePpn',
  'saleStatus',
  'customer',
  'product',
])
</script>

<template>
  <Card>
    <template #title>
      <h2 class="text-2xl font-bold">Detail Penjualan</h2>
    </template>
    <template #content>
      <div class="grid">
        <div class="col-12">
          <div class="grid">
            <div class="col">
              <h3 class="text-base">Nomor Penjualan</h3>
              <span>{{ saleNumber }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">Status Penjualan</h3>
              <span>{{ saleStatus }}</span>
            </div>

            <div class="col"></div>
          </div>
        </div>

        <div
          v-if="
            customer !== null &&
            typeof customer === 'object' &&
            Object.keys(customer).length
          "
          class="col-12"
        >
          <div class="grid">
            <div class="col">
              <h3 class="text-base">Nama</h3>
              <span>{{ customer.name }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">Alamat</h3>
              <span>{{ customer.address }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">NPWP</h3>
              <span>{{ customer.npwp }}</span>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div
            v-if="
              product !== null &&
              typeof product === 'object' &&
              Object.keys(product).length
            "
            class="grid"
          >
            <div class="col">
              <h3 class="text-base">Nomor Produk</h3>
              <span>{{ product.number }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">Nama Produk</h3>
              <span>{{ product.name }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">Satuan</h3>
              <span>{{ product.unit }}</span>
            </div>
          </div>
        </div>

        <Divider type="dashed" />
        <div class="col-12">
          <div class="grid">
            <div class="col">
              <h3 class="text-base">Harga</h3>
              <span>{{ salePrice }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">Kuantitas</h3>
              <span>{{ saleQty }}</span>
            </div>

            <div class="col">
              <h3 class="text-base">PPN</h3>
              <span>{{ salePpn }} %</span>
            </div>
          </div>
        </div>
      </div>
    </template>
  </Card>
</template>
