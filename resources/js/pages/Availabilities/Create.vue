<template>
  <AppLayout>
    <div class="max-w-lg mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">Nova Disponibilidade</h1>
      <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded shadow">
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Dia da Semana</label>
          <select v-model.number="form.weekday" class="w-full border rounded px-3 py-2" style="color: #000;" required>
            <option v-for="(d, i) in weekdays" :key="i" :value="i">{{ d }}</option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Início</label>
          <input v-model="form.start_time" type="time" class="w-full border rounded px-3 py-2" style="color: #000;" required />
        </div>
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Fim</label>
          <input v-model="form.end_time" type="time" class="w-full border rounded px-3 py-2" style="color: #000;" required />
        </div>
        <div class="flex gap-2">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
          <Link href="/availabilities" class="px-4 py-2 rounded border" style="color: #000;">Cancelar</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const weekdays = [
  'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'
];

const form = ref({
  weekday: 1,
  start_time: '',
  end_time: '',
});

function submit() {
  router.post('/availabilities', form.value);
}
</script> 