<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const events = usePage().props.events || [];
const baseUrl = window.location.origin;
const copied = ref(null);

function copyLink(slug) {
  const url = `${baseUrl}/book/${slug}`;
  navigator.clipboard.writeText(url);
  copied.value = slug;
  setTimeout(() => copied.value = null, 1500);
}
</script>

<template>
  <AppLayout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 py-12">
      <div class="w-full max-w-3xl bg-white/10 backdrop-blur-md rounded-3xl shadow-2xl p-10 border border-white/20">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 text-transparent bg-clip-text drop-shadow-lg mb-8">
          Seus links públicos de agendamento
        </h1>
        <div v-if="events.length === 0" class="text-gray-300 text-lg text-center py-12">Nenhum evento cadastrado.</div>
        <div v-else class="overflow-x-auto">
          <table class="min-w-full rounded-2xl overflow-hidden shadow-xl">
            <thead>
              <tr class="bg-gradient-to-r from-gray-800 to-gray-900">
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Evento</th>
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Link público</th>
                <th class="py-3 px-6 text-left text-gray-200 font-semibold">Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="event in events" :key="event.id" class="bg-gray-800/70 border-b border-gray-700 hover:bg-gray-700/80 transition">
                <td class="py-3 px-6 text-gray-100">{{ event.name }}</td>
                <td class="py-3 px-6">
                  <a :href="`/book/${event.slug}`" target="_blank" class="text-blue-400 underline hover:text-blue-300 transition">
                    {{ baseUrl + '/book/' + event.slug }}
                  </a>
                </td>
                <td class="py-3 px-6">
                  <button @click="copyLink(event.slug)" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white px-4 py-1.5 rounded-lg shadow hover:scale-105 transition-transform duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <svg v-if="copied !== event.slug" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-8-4h8M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <span v-if="copied === event.slug">Copiado!</span>
                    <span v-else>Copiar</span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="mt-8 text-gray-400 text-sm text-center">
          Compartilhe o link público do evento com seus clientes para que possam agendar diretamente.
        </div>
      </div>
    </div>
  </AppLayout>
</template> 