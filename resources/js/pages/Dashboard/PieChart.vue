<script setup>
import VueApexCharts from 'vue3-apexcharts';
const props = defineProps({ data: Object });
const series = Object.values(props.data || {});
const labels = Object.keys(props.data || {});
const options = {
  chart: { type: 'pie' },
  labels,
  theme: { mode: 'dark' },
  legend: { labels: { colors: '#fff' } },
  colors: ['#6366f1', '#a21caf', '#f59e42', '#10b981', '#ef4444'],
};
</script>
<template>
  <VueApexCharts type="pie" :options="options" :series="series" height="260" />
</template> 