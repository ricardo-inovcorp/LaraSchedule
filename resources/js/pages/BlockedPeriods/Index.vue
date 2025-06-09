<template>
  <AppLayout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 py-12">
      <div class="w-full max-w-3xl bg-white/10 backdrop-blur-md rounded-3xl shadow-2xl p-10 border border-white/20">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
          <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 text-transparent bg-clip-text drop-shadow-lg">
            Meus Bloqueios
          </h1>
          <Link href="/blocked-periods/create" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-xl shadow-lg font-semibold text-lg hover:scale-105 hover:from-blue-500 hover:to-purple-500 transition-transform duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Novo Bloqueio
          </Link>
        </div>
        <div v-if="blockedPeriods.length === 0" class="text-gray-300 text-lg text-center py-12">Nenhum bloqueio cadastrado.</div>
        <div v-else class="overflow-x-auto">
          <table class="min-w-full rounded-2xl overflow-hidden shadow-xl">
            <thead>
              <tr class="bg-gradient-to-r from-gray-800 to-gray-900">
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Início</th>
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Fim</th>
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Motivo</th>
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="b in blockedPeriods" :key="b.id" class="bg-gray-800/70 border-b border-gray-700 hover:bg-gray-700/80 transition">
                <td class="py-3 px-6 text-gray-100">{{ b.start_date }}</td>
                <td class="py-3 px-6 text-gray-100">{{ b.end_date }}</td>
                <td class="py-3 px-6 text-gray-100">{{ b.motivo }}</td>
                <td class="py-3 px-6 flex gap-2">
                  <Link :href="`/blocked-periods/${b.id}/edit`" class="inline-flex items-center gap-1 bg-gradient-to-r from-blue-500 to-purple-500 text-white px-3 py-1.5 rounded-lg shadow hover:scale-105 transition-transform duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6" /></svg>
                    Editar
                  </Link>
                  <form :action="`/blocked-periods/${b.id}`" method="POST" @submit.prevent="askDelete(b.id)">
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
      <template #message>Tem certeza que deseja excluir este bloqueio? Esta ação não pode ser desfeita.</template>
    </ConfirmModal>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
const props = defineProps({ blockedPeriods: Array });

const showModal = ref(false);
const blockedPeriodToDelete = ref(null);

function askDelete(id) {
  blockedPeriodToDelete.value = id;
  showModal.value = true;
}
function confirmDelete() {
  if (blockedPeriodToDelete.value) {
    router.delete(`/blocked-periods/${blockedPeriodToDelete.value}`);
  }
  showModal.value = false;
  blockedPeriodToDelete.value = null;
}
function cancelDelete() {
  showModal.value = false;
  blockedPeriodToDelete.value = null;
}
</script> 