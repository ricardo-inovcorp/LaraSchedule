<template>
  <AppLayout>
    <div class="max-w-3xl mx-auto py-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Meus Bloqueios</h1>
        <Link href="/blocked-periods/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Novo Bloqueio</Link>
      </div>
      <div v-if="blockedPeriods.length === 0" class="text-gray-500">Nenhum bloqueio cadastrado.</div>
      <div v-else>
        <table class="min-w-full bg-white rounded shadow">
          <thead>
            <tr>
              <th class="py-2 px-4 text-left" style="color: #000;">Início</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Fim</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Motivo</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="b in blockedPeriods" :key="b.id">
              <td class="py-2 px-4" style="color: #000;">{{ b.start_date }}</td>
              <td class="py-2 px-4" style="color: #000;">{{ b.end_date }}</td>
              <td class="py-2 px-4" style="color: #000;">{{ b.motivo }}</td>
              <td class="py-2 px-4 flex gap-2">
                <Link :href="`/blocked-periods/${b.id}/edit`" class="text-blue-600 hover:underline">Editar</Link>
                <form :action="`/blocked-periods/${b.id}`" method="POST" @submit.prevent="destroy(b.id)">
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
const props = defineProps({ blockedPeriods: Array });

function destroy(id) {
  if (confirm('Tem certeza que deseja excluir este bloqueio?')) {
    router.delete(`/blocked-periods/${id}`);
  }
}
</script> 