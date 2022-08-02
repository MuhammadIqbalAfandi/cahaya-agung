<script setup>
import { watch, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import dayjs from 'dayjs'
import { pickBy } from 'lodash'
import { computed } from '@vue/reactivity'

const props = defineProps({
  initialFilter: {
    type: Object,
    required: true,
  },
  url: {
    type: String,
    required: true,
  },
  refreshData: {
    type: Array,
    default: [],
    required: false,
  },
})

const initialFilter = computed(() => {
  if (props.initialFilter.start_date || props.initialFilter.end_date) {
    if (props.initialFilter.end_date) {
      return [
        new Date(props.initialFilter.start_date),
        new Date(props.initialFilter.end_date),
      ]
    } else {
      return [new Date(props.initialFilter.start_date), null]
    }
  }
})

const dates = ref(initialFilter.value)

watch(dates, (value) => {
  if (value[1]) {
    var start_date = dayjs(value[0]).format('YYYY-MM-DD')

    var end_date = dayjs(value[1]).format('YYYY-MM-DD')
  } else if (value[0]) {
    var start_date = dayjs(value[0]).format('YYYY-MM-DD')

    var end_date = null
  }

  Inertia.get(
    props.url,
    pickBy({
      start_date,
      end_date,
    }),
    {
      preserveState: true,
      only: [...props.refreshData],
    }
  )
})
</script>

<template>
  <Calendar
    class="w-full"
    selection-mode="range"
    date-format="dd/mm/yy"
    :manual-input="false"
    v-model="dates"
  />
</template>
