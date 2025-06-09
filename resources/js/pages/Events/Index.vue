<template>
  <AppLayout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 py-12">
      <div class="w-full max-w-3xl bg-white/10 backdrop-blur-md rounded-3xl shadow-2xl p-10 border border-white/20">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
          <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 text-transparent bg-clip-text drop-shadow-lg">
            Meus Eventos
          </h1>
          <Link href="/events/create" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-xl shadow-lg font-semibold text-lg hover:scale-105 hover:from-blue-500 hover:to-purple-500 transition-transform duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Novo Evento
          </Link>
        </div>
        <div v-if="events.length === 0" class="text-gray-300 text-lg text-center py-12">Nenhum evento cadastrado.</div>
        <div v-else class="overflow-x-auto">
          <table class="min-w-full rounded-2xl overflow-hidden shadow-xl">
            <thead>
              <tr class="bg-gradient-to-r from-gray-800 to-gray-900">
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Nome</th>
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Duração</th>
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="event in events" :key="event.id" class="bg-gray-800/70 border-b border-gray-700 hover:bg-gray-700/80 transition">
                <td class="py-3 px-6 text-gray-100">{{ event.name }}</td>
                <td class="py-3 px-6 text-gray-100">{{ event.duration }} min</td>
                <td class="py-3 px-6 flex gap-2">
                  <Link :href="`/events/${event.id}/edit`" class="inline-flex items-center gap-1 bg-gradient-to-r from-blue-500 to-purple-500 text-white px-3 py-1.5 rounded-lg shadow hover:scale-105 transition-transform duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6" /></svg>
                    Editar
                  </Link>
                  <form :action="`/events/${event.id}`" method="POST" @submit.prevent="askDelete(event.id)">
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" class="inline-flex items-center gap-1 bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1.5 rounded-lg shadow hover:scale-105 transition-transform duration-150">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                      Excluir
                    </button>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <ConfirmModal :show="showModal" @confirm="confirmDelete" @cancel="cancelDelete">
      <template #title>Confirmar Exclusão</template>
      <template #message>Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.</template>
    </ConfirmModal>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
const props = defineProps({ events: Array });

const showModal = ref(false);
const eventToDelete = ref(null);

function askDelete(id) {
  eventToDelete.value = id;
  showModal.value = true;
}
function confirmDelete() {
  if (eventToDelete.value) {
    router.delete(`/events/${eventToDelete.value}`);
  }
  showModal.value = false;
  eventToDelete.value = null;
}
function cancelDelete() {
  showModal.value = false;
  eventToDelete.value = null;
}
</script> 