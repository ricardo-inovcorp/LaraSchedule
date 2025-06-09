<template>
  <AppLayout>
    <div class="max-w-3xl mx-auto py-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Minhas Disponibilidades</h1>
        <Link href="/availabilities/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nova Disponibilidade</Link>
      </div>
      <div v-if="availabilities.length === 0" class="text-gray-500">Nenhuma disponibilidade cadastrada.</div>
      <div v-else>
        <table class="min-w-full bg-white rounded shadow">
          <thead>
            <tr>
              <th class="py-2 px-4 text-left" style="color: #000;">Dia da Semana</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Início</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Fim</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="a in availabilities" :key="a.id">
              <td class="py-2 px-4" style="color: #000;">{{ weekdays[a.weekday] }}</td>
              <td class="py-2 px-4" style="color: #000;">{{ a.start_time }}</td>
              <td class="py-2 px-4" style="color: #000;">{{ a.end_time }}</td>
              <td class="py-2 px-4 flex gap-2">
                <Link :href="`/availabilities/${a.id}/edit`" class="text-blue-600 hover:underline">Editar</Link>
                <form :action="`/availabilities/${a.id}`" method="POST" @submit.prevent="destroy(a.id)">
                  <input type="hidden" name="_method" value="DELETE" />
                  <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
const props = defineProps({ availabilities: Array });

const weekdays = [
  'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'
];

function destroy(id) {
  if (confirm('Tem certeza que deseja excluir esta disponibilidade?')) {
    router.delete(`/availabilities/${id}`);
  }
}
</script> 