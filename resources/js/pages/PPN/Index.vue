<script setup>
import { ref } from 'vue'
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'
import DashboardLayout from '@/layouts/Dashboard/DashboardLayout.vue'

const props = defineProps({
  ppn: Number,
})

const form = useForm({
  ppn: props.ppn,
})

const inputDisable = ref(true)

const buttonLabel = ref('Ubah')

const onSubmit = () => {
  if (inputDisable.value) {
    buttonLabel.value = 'Simpan'

    inputDisable.value = false
  } else {
    if (!form.ppn) {
      form.ppn = 0
    }

    buttonLabel.value = 'Ubah'

    inputDisable.value = true

    form.post(route('ppn.store'))
  }
}
</script>

<template>
  <DashboardLayout title="Pengaturan PPN">
    <div class="grid">
      <div class="col-12 md:col-3">
        <Card>
          <template #content>
            <div class="grid">
              <div class="col-12">
                <AppInputText
                  label="PPN"
                  placeholder="ppn"
                  type="number"
                  :disabled="inputDisable"
                  :error="form.errors.ppn"
                  v-model="form.ppn"
                />
              </div>

              <div class="col-12">
                <div class="flex flex-column md:flex-row justify-content-end">
                  <Button
                    icon="pi pi-check"
                    class="p-button-outlined"
                    :label="buttonLabel"
                    :disabled="form.processing"
                    @click="onSubmit"
                  />
                </div>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </div>
  </DashboardLayout>
</template>
