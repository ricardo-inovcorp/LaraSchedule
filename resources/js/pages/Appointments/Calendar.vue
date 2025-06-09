<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import Calendar from '../Dashboard/Calendar.vue';
const props = defineProps({ appointments: Array });
</script>
<template>
  <AppLayout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 py-10 px-4 flex flex-col items-center">
      <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 text-transparent bg-clip-text drop-shadow-lg mb-8">
        Meu Calendário de Agendamentos
      </h1>
      <div class="w-full max-w-4xl">
        <Calendar :agendamentos="props.appointments" :bloqueios="[]" />
      </div>
    </div>
  </AppLayout>
</template> 