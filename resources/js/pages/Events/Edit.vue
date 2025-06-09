<template>
  <AppLayout>
    <div class="max-w-lg mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">Editar Evento</h1>
      <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded shadow">
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Nome</label>
          <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" style="color: #000;" required />
        </div>
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Descrição</label>
          <textarea v-model="form.description" class="w-full border rounded px-3 py-2" style="color: #000;" rows="3"></textarea>
        </div>
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Duração (minutos)</label>
          <input v-model.number="form.duration" type="number" min="1" class="w-full border rounded px-3 py-2" style="color: #000;" required />
        </div>
        <div class="flex gap-2">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
          <Link href="/events" class="px-4 py-2 rounded border" style="color: #000;">Cancelar</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({ event: Object });

const form = ref({
  name: props.event.name,
  description: props.event.description,
  duration: props.event.duration,
});

function submit() {
  router.put(`/events/${props.event.id}`, form.value);
}
</script> 