<template>
  <AppLayout>
    <div class="max-w-lg mx-auto py-8">
      <h1 class="text-2xl font-bold mb-6">Editar Bloqueio</h1>
      <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded shadow">
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Início</label>
          <input v-model="form.start_date" type="date" class="w-full border rounded px-3 py-2" style="color: #000;" required />
        </div>
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Fim</label>
          <input v-model="form.end_date" type="date" class="w-full border rounded px-3 py-2" style="color: #000;" required />
        </div>
        <div>
          <label class="block mb-1 font-medium" style="color: #000;">Motivo</label>
          <input v-model="form.motivo" type="text" class="w-full border rounded px-3 py-2" style="color: #000;" />
        </div>
        <div class="flex gap-2">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
          <Link href="/blocked-periods" class="px-4 py-2 rounded border" style="color: #000;">Cancelar</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({ blockedPeriod: Object });

const form = ref({
  start_date: props.blockedPeriod.start_date,
  end_date: props.blockedPeriod.end_date,
  motivo: props.blockedPeriod.motivo,
});

function submit() {
  router.put(`/blocked-periods/${props.blockedPeriod.id}`, form.value);
}
</script> 