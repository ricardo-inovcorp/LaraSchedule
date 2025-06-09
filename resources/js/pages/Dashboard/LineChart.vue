<script setup>
import VueApexCharts from 'vue3-apexcharts';
const props = defineProps({ data: Object });
const series = [{
  name: 'Agendamentos',
  data: Object.values(props.data || {})
}];
const categories = Object.keys(props.data || {});
const options = {
  chart: { type: 'line', toolbar: { show: false } },
  xaxis: { categories },
  theme: { mode: 'dark' },
  colors: ['#6366f1'],
  dataLabels: { enabled: false },
  stroke: { curve: 'smooth' },
  grid: { borderColor: '#222' },
};
</script>
<template>
  <VueApexCharts type="line" :options="options" :series="series" height="260" />
</template> 