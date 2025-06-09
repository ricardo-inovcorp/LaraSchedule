<script setup>
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';
import { router } from '@inertiajs/vue3';
const props = defineProps({ agendamentos: Array, bloqueios: Array });

const events = [
  ...(props.agendamentos || []).map(a => ({
    start: a.start_datetime,
    end: a.end_datetime || a.start_datetime,
    title: a.name || 'Agendamento',
    id: a.id,
    class: 'bg-blue-500 text-white',
    isAppointment: true,
  })),
  ...(props.bloqueios || []).map(b => ({
    start: b.start_date,
    end: b.end_date,
    title: b.motivo || 'Bloqueio',
    content: b.motivo || 'Bloqueio',
    class: 'bg-red-500 text-white',
    isAppointment: false,
  })),
];

function onEventClick(event) {
  if (event.isAppointment && event.id) {
    router.visit(`/appointments/${event.id}`);
  }
}
</script>
<template>
  <VueCal :events="events" style="height: 320px; border-radius: 1rem; overflow: hidden;" hide-view-selector default-view="month" :time="false" @event-click="onEventClick" />
</template> 