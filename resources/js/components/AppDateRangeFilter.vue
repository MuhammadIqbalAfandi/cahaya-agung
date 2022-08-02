<script setup>
import { onMounted, reactive, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import dayjs from 'dayjs'
import { pickBy } from 'lodash'

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

const filters = reactive({
  dates: null,
  startDate: null,
  endDate: null,
})

onMounted(() => {
  if (props.initialFilter.start_date || props.initialFilter.end_date) {
    if (props.initialFilter.end_date) {
      filters.dates = [
        new Date(props.initialFilter.start_date),
        new Date(props.initialFilter.end_date),
      ]
    } else {
      filters.dates = [new Date(props.initialFilter.start_date), null]
    }
  }
})

watch(
  () => filters.dates,
  () => {
    if (filters.dates[1]) {
      filters.startDate = dayjs(filters.dates[0]).format('YYYY-MM-DD')

      filters.endDate = dayjs(filters.dates[1]).format('YYYY-MM-DD')
    } else if (filters.dates[0]) {
      filters.startDate = dayjs(filters.dates[0]).format('YYYY-MM-DD')

      filters.endDate = null
    }

    Inertia.get(
      props.url,
      pickBy({
        start_date: filters.startDate,
        end_date: filters.endDate,
      }),
      {
        preserveState: true,
        only: [...props.refreshData],
      }
    )
  }
)
</script>

<template>
  <Calendar
    class="w-full"
    selection-mode="range"
    date-format="dd/mm/yy"
    :manual-input="false"
    v-model="filters.dates"
  />
</template>
