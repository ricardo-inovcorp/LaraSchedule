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
    <div class="max-w-2xl mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6" style="color: #000;">Seus links públicos de agendamento</h1>
      <div v-if="events.length === 0" class="text-gray-500">Nenhum evento cadastrado.</div>
      <div v-else>
        <table class="min-w-full bg-white rounded shadow">
          <thead>
            <tr>
              <th class="py-2 px-4 text-left" style="color: #000;">Evento</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Link público</th>
              <th class="py-2 px-4 text-left" style="color: #000;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="event in events" :key="event.id">
              <td class="py-2 px-4" style="color: #000;">{{ event.name }}</td>
              <td class="py-2 px-4" style="color: #000;">
                <a :href="`/book/${event.slug}`" target="_blank" class="text-blue-600 underline">
                  {{ baseUrl + '/book/' + event.slug }}
                </a>
              </td>
              <td class="py-2 px-4" style="color: #000;">
                <button @click="copyLink(event.slug)" class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">
                  <span v-if="copied === event.slug">Copiado!</span>
                  <span v-else>Copiar link</span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-6 text-gray-600 text-sm" style="color: #000;">
        Compartilhe o link público do evento com seus clientes para que possam agendar diretamente.
      </div>
    </div>
  </AppLayout>
</template> 