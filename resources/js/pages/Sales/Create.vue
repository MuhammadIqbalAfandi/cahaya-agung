<script setup>
import { useForm, Head } from '@inertiajs/inertia-vue3'
import { useFormErrorReset } from '@/components/useFormErrorReset'
import AppInputText from '@/components/AppInputText.vue'
import AppInputNumber from '@/components/AppInputNumber.vue'
import AppDropdown from '@/components/AppDropdown.vue'
import AppAutocompleteBasic from '@/components/AppAutocompleteBasic.vue'
import DashboardLayout from '@/layouts/DashboardLayout.vue'

defineProps({
  customers: Object,
})

const form = useForm({
  number: null,
  status: null,
  price: null,
  qty: null,
  customer_id: null,
})

useFormErrorReset(form)

const optionStatus = [
  {
    label: 'Pending',
    value: 'pending',
  },
  {
    label: 'Success',
    value: 'success',
  },
]

const customerOnComplete = (event) => {
  Inertia.reload({
    data: { search: event.query },
    only: ['customers'],
  })
}

const customerOnSelected = (event) => {
  form.customer = event.value
}

const onSubmit = () => {
  form.post(route('sales.store'), { onSuccess: () => form.reset() })
}
</script>

<template>
  <Head title="Tambah Penjualan" />

  <DashboardLayout>
    <div class="grid">
      <div class="col-12 lg:col-8">
        <Card>
          <template #title> Tambah Penjualan </template>
          <template #content>
            <div class="grid">
              <div class="col-12 md:col-6">
                <AppInputText
                  label="Nomor Penjualan"
                  placeholder="nomor penjualan"
                  type="number"
                  :error="form.errors.number"
                  v-model="form.number"
                />
              </div>

              <div class="col-12 md:col-6">
                <!-- <AppDropdown
                  label="Status"
                  placeholder="status"
                  :option="optionStatus"
                  :error="form.errors.status"
                  v-model="form.status"
                /> -->
              </div>

              <div class="col-12 md:col-6">
                <AppInputNumber
                  label="Harga"
                  placeholder="harga"
                  :error="form.errors.price"
                  v-model="form.price"
                />
              </div>

              <div class="col-12 md:col-6">
                <AppInputText
                  label="Kuantitas"
                  placeholder="kuantitas"
                  :error="form.errors.qty"
                  v-model="form.qty"
                />
              </div>

              <div class="col-12 md:col-6">
                <AppAutocompleteBasic
                  label="Pelanggan"
                  placeholder="pelanggan"
                  :error="form.errors.customer_id"
                  v-model="form.customer_id"
                  @suggestions="customers"
                  @complete="customerOnComplete"
                  @item-select="customerOnSelected"
                >
                  <template #item="slotProps">
                    <template v-if="slotProps.item">
                      <div class="flex flex-column">
                        <span>{{ slotProps.item.name }}</span>
                        <span>{{ slotProps.item.type }}</span>
                        <span class="font-bold">{{
                          slotProps.item.platNumber
                        }}</span>
                      </div>
                    </template>
                  </template>

                  <template #empty>
                    <span
                      class="cursor-pointer"
                      style="color: var(--primary-color)"
                      @click="gotoMember"
                    >
                      Tambah Produk
                    </span>
                  </template>
                </AppAutocompleteBasic>
              </div>
            </div>
          </template>

          <template #footer>
            <div class="flex flex-column md:flex-row justify-content-end">
              <Button
                label="Simpan"
                icon="pi pi-check"
                class="p-button-outlined"
                :disabled="form.processing"
                @click="onSubmit"
              />
            </div>
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
