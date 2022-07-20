<script setup>
import { inject } from 'vue'

const form = inject('form')
</script>

<template>
  <div class="grid">
    <div class="col-12">
      <h1 class="text-lg font-bold">Tampilan Invoice</h1>
    </div>
  </div>

  <h1 style="text-align: right; margin: 0; margin-right: 15%">
    <strong style="text-transform: uppercase; font-size: medium"
      >INVOICE</strong
    >
  </h1>

  <table>
    <tr>
      <td style="width: 65%">
        <table>
          <tr>
            <td><strong>Kepada</strong></td>
            <td>:</td>
            <td style="padding: 0">
              <table style="border-spacing: 0">
                <tr>
                  <td>Partner Company</td>
                </tr>
                <tr>
                  <td>Anonym</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><strong>NPWP</strong></td>
            <td>:</td>
            <td style="padding: 0">
              <table style="border-spacing: 0">
                <tr>
                  <td>XXXXXXXXXXXXXXX</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
      <td style="width: 35%">
        <table>
          <tr>
            <td>
              <table>
                <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td>{{ form.name }}</td>
                </tr>
                <tr>
                  <td>NPWP</td>
                  <td>:</td>
                  <td>{{ form.npwp }}</td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td>{{ form.email }}</td>
                </tr>
                <tr>
                  <td>No Telepon</td>
                  <td>:</td>
                  <td>{{ form.telephone }}</td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>:</td>
                  <td>{{ form.address }}</td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td>:</td>
                  <td>Anonym</td>
                </tr>
                <tr>
                  <td>Nomor Pembelian</td>
                  <td>:</td>
                  <td>PJN20220720115908</td>
                </tr>
                <tr>
                  <td>Halaman</td>
                  <td>:</td>
                  <td>1</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</template>

<style scoped>
table {
  font-family: Verdana, Arial, sans-serif;
  font-size: x-small;
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
}

tr {
  vertical-align: super;
}

tfoot tr td {
  font-weight: bold;
  font-size: x-small;
}
</style>
