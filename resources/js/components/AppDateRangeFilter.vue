<script setup>
import { watch, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import dayjs from 'dayjs'
import { pickBy } from 'lodash'
import { computed } from '@vue/reactivity'

const props = defineProps({
  initialDateRage: {
    type: Object,
    required: true,
  },
  nameParam: {
    type: Array,
    required: true,
  },
})

const initialDateRage = computed(() => {
  if (
    props.initialDateRage[props.nameParam[0]] ||
    props.initialDateRage[props.nameParam[1]]
  ) {
    if (props.initialDateRage[props.nameParam[1]]) {
      return [
        new Date(props.initialDateRage[props.nameParam[0]]),
        new Date(props.initialDateRage[props.nameParam[1]]),
      ]
    } else {
      return [new Date(props.initialDateRage[props.nameParam[0]]), null]
    }
  }
})

const removeParams = (...params) => {
  const urlParams = new URLSearchParams(location.search)

  params.forEach((value) => urlParams.delete(value))

  history.replaceState({}, '', `${location.pathname}?${urlParams}`)
}

const dates = ref(initialDateRage.value)

watch(dates, (value) => {
  if (value[1]) {
    var start = dayjs(value[0]).format('YYYY-MM-DD')

    var end = dayjs(value[1]).format('YYYY-MM-DD')
  } else if (value[0]) {
    var start = dayjs(value[0]).format('YYYY-MM-DD')

    var end = null
  }

  removeParams(props.nameParam[0], props.nameParam[1], 'page')

  Inertia.reload({
    data: pickBy({
      [props.nameParam[0]]: start,
      [props.nameParam[1]]: end,
    }),
  })
})
</script>

<template>
  <Calendar
    class="w-full"
    selection-mode="range"
    date-format="dd/mm/yy"
    :placeholder="$attrs.placeholder"
    :manual-input="false"
    v-model="dates"
  />
</template>
