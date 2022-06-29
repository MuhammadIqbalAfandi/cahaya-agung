import { onMounted, watch, ref } from 'vue'
import dayjs from 'dayjs'

export function useDateRangeFilter(props) {
  const dates = ref(null)

  const startDate = ref(null)

  const endDate = ref(null)

  onMounted(() => {
    if (!props.initialDateRange) {
      return
    }

    if (props.initialDateRange[0] || props.initialDateRange[1]) {
      if (props.initialDateRange[1]) {
        dates.value = [
          new Date(props.initialDateRange[0]),
          new Date(props.initialDateRange[1]),
        ]
      } else {
        dates.value = [new Date(props.props.initialDateRange[1]), null]
      }
    }
  })

  watch(dates, () => {
    if (dates.value[1]) {
      startDate.value = dayjs(dates.value[0]).format('YYYY-MM-DD')

      endDate.value = dayjs(dates.value[1]).format('YYYY-MM-DD')
    } else if (dates.value[0]) {
      startDate.value = dayjs(dates.value[0]).format('YYYY-MM-DD')

      endDate.value = null
    }
  })

  return {
    dates,
    startDate,
    endDate,
  }
}
