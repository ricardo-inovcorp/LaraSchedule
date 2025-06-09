<template>
  <AppLayout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 py-12">
      <div class="w-full max-w-lg bg-white/10 backdrop-blur-md rounded-3xl shadow-2xl p-10 border border-white/20">
        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 text-transparent bg-clip-text drop-shadow-lg mb-6">
          Editar Disponibilidade
        </h1>
        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <label class="block mb-1 font-medium text-gray-200">Dia da Semana</label>
            <select v-model.number="form.weekday" class="w-full border-none rounded-lg px-4 py-3 bg-gray-800/80 text-gray-100 focus:ring-2 focus:ring-blue-500 transition" required>
              <option v-for="(d, i) in weekdays" :key="i" :value="i">{{ d }}</option>
            </select>
          </div>
          <div>
            <label class="block mb-1 font-medium text-gray-200">Início</label>
            <input v-model="form.start_time" type="time" class="w-full border-none rounded-lg px-4 py-3 bg-gray-800/80 text-gray-100 focus:ring-2 focus:ring-blue-500 transition" required />
          </div>
          <div>
            <label class="block mb-1 font-medium text-gray-200">Fim</label>
            <input v-model="form.end_time" type="time" class="w-full border-none rounded-lg px-4 py-3 bg-gray-800/80 text-gray-100 focus:ring-2 focus:ring-blue-500 transition" required />
          </div>
          <div class="flex gap-2">
            <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg font-semibold text-lg hover:scale-105 hover:from-blue-500 hover:to-purple-500 transition-transform duration-200">Salvar</button>
            <Link href="/availabilities" class="px-6 py-3 rounded-xl border border-gray-700 text-gray-200 hover:bg-gray-800/50 transition">Cancelar</Link>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({ availability: Object });

const weekdays = [
  'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'
];

const form = ref({
  weekday: props.availability.weekday,
  start_time: props.availability.start_time,
  end_time: props.availability.end_time,
});

function submit() {
  router.put(`/availabilities/${props.availability.id}`, form.value);
}
</script> 