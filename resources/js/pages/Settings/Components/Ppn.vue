<script setup>
import { useState } from '../Composables/useState'
import { useForm } from '@/composables/useForm'
import AppInputText from '@/components/AppInputText.vue'

const props = defineProps({
  ppn: Object,
})

const form = useForm({
  ppn: props.ppn.ppn,
})

const { state, setState } = useState()

const onSubmit = () => {
  setState()

  if (!form.ppn) {
    form.ppn = 0
  }

  form.post(route('ppn.store'))
}
</script>

<template>
  <div class="grid">
    <div class="col-12">
      <h1 class="text-lg">Pajak Pertambahan Nilai</h1>
    </div>

    <div class="col-12">
      <AppInputText
        label="PPN %"
        placeholder="ppn"
        type="number"
        :disabled="state.disable"
        :error="form.errors.ppn"
        v-model="form.ppn"
      />
    </div>

    <div class="col-12">
      <div class="flex flex-column sm:flex-row justify-content-end">
        <Button
          class="p-button-outlined"
          :icon="state.icon"
          :label="state.label"
          :disabled="form.processing"
          @click="onSubmit"
        />
      </div>
    </div>
  </div>
</template>
