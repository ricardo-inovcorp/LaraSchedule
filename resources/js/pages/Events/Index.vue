<template>
  <AppLayout>
    <div class="max-w-3xl mx-auto py-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Meus Eventos</h1>
        <Link href="/events/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Novo Evento</Link>
      </div>
      <div v-if="events.length === 0" class="text-gray-500">Nenhum evento cadastrado.</div>
      <div v-else>
        <table class="min-w-full bg-white rounded shadow">
          <thead>
            <tr>
              <th class="py-2 px-4 text-left" style="color: #000;">Nome</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Duração</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="event in events" :key="event.id">
              <td class="py-2 px-4" style="color: #000;">{{ event.name }}</td>
              <td class="py-2 px-4" style="color: #000;">{{ event.duration }} min</td>
              <td class="py-2 px-4 flex gap-2">
                <Link :href="`/events/${event.id}/edit`" class="text-blue-600 hover:underline" style="color:blue;">Editar</Link>
                <form :action="`/events/${event.id}`" method="POST" @submit.prevent="destroy(event.id)">
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
const props = defineProps({ events: Array });

function destroy(id) {
  if (confirm('Tem certeza que deseja excluir este evento?')) {
    router.delete(`/events/${id}`);
  }
}
</script> 