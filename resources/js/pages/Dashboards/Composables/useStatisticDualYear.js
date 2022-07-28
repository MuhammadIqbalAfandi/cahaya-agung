export function useStatisticDualYear(chartData) {
  const chartSettings = {
    title: null,
    datasets: [
      {
        label: '-',
        data: [],
        fill: false,
        backgroundColor: '#2f4860',
        borderColor: '#2f4860',
        tension: 0.4,
      },
      {
        label: '-',
        data: [],
        fill: false,
        backgroundColor: '#00bb7e',
        borderColor: '#00bb7e',
        tension: 0.4,
      },
    ],
  }

  let index = 0

  for (const key in chartData.data) {
    chartSettings.datasets[index].label = key
    chartSettings.datasets[index].data = chartData.data[key]

    index++
  }

  return { title: chartData.title, data: chartSettings }
}
