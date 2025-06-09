<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({ appointment: Object });
const page = usePage();
const success = ref((page.props.flash && page.props.flash.success) || '');

function approve() {
  router.post(`/appointments/${props.appointment.id}/approve`);
}
function reject() {
  router.post(`/appointments/${props.appointment.id}/reject`);
}
</script>
<template>
  <AppLayout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 py-10 px-4 flex flex-col items-center">
      <div class="w-full max-w-lg bg-white/10 backdrop-blur-md rounded-3xl shadow-2xl p-8 border border-white/20">
        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 text-transparent bg-clip-text drop-shadow-lg mb-6">
          Detalhe do Agendamento
        </h1>
        <div class="space-y-4 text-gray-100">
          <div><span class="font-semibold">Nome:</span> {{ props.appointment.name }}</div>
          <div><span class="font-semibold">E-mail:</span> {{ props.appointment.email }}</div>
          <div><span class="font-semibold">Data/Hora:</span> {{ props.appointment.start_datetime }}</div>
          <div><span class="font-semibold">Status:</span> {{ props.appointment.status }}</div>
        </div>
        <div v-if="props.appointment.status === 'pending'" class="flex gap-2 mt-6">
          <button @click="approve" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl shadow transition">Aprovar</button>
          <button @click="reject" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl shadow transition">Recusar</button>
        </div>
        <div v-if="success" class="flex flex-col items-center text-green-400 mt-4 text-center font-semibold animate-pulse">
          <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
          {{ success }}
        </div>
        <div class="mt-8 flex justify-end">
          <Link href="/calendar" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-xl shadow hover:scale-105 transition">Voltar ao Calendário</Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template> 