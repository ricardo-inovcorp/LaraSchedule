<template>
  <div style="min-height:100vh; background:#fff; color:#222;">
    <Head :title="event && event.name ? `Agendar: ${event.name}` : 'Agendamento'" />
    <div class="max-w-xl mx-auto py-8">
      <template v-if="event && event.name">
        <h1 class="text-2xl font-bold mb-2">Agendar: {{ event.name }}</h1>
        <p class="mb-4 text-gray-700">{{ event.description }}</p>
        <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded shadow">
          <div>
            <label class="block mb-1 font-medium" style="color: #000;" >Nome</label>
            <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" required />
          </div>
          <div>
            <label class="block mb-1 font-medium" style="color: #000;" >E-mail</label>
            <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" required />
          </div>
          <div>
            <label class="block mb-1 font-medium" style="color: #000;" >Data</label>
            <input v-model="form.date" type="date" class="w-full border rounded px-3 py-2" required />
          </div>
          <div>
            <label class="block mb-1 font-medium" style="color: #000;" >Horário</label>
            <select v-model="form.time" class="w-full border rounded px-3 py-2" required>
              <option value="" disabled>Selecione...</option>
              <option v-for="h in availableTimes" :key="h" :value="h">{{ h }}</option>
            </select>
          </div>
          <div v-for="field in customFields" :key="field.id">
            <label class="block mb-1 font-medium">{{ field.label }}<span v-if="field.required">*</span></label>
            <input v-if="field.type === 'text'" v-model="form.custom[field.id]" type="text" class="w-full border rounded px-3 py-2" :required="field.required" />
            <!-- Adicione outros tipos conforme necessário -->
          </div>
          <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Agendar</button>
          </div>
          <div v-if="success" class="text-green-600 mt-2">{{ success }}</div>
        </form>
      </template>
      <template v-else>
        <div class="text-center text-gray-600 text-lg py-12">
          Evento não encontrado ou link inválido.<br />
          Verifique o link ou entre em contato com quem enviou.
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router, usePage, Head } from '@inertiajs/vue3';
const props = defineProps({ event: Object, availabilities: Array, blockedPeriods: Array, appointments: Array, customFields: Array });

const form = ref({
  name: '',
  email: '',
  date: '',
  time: '',
  custom: {},
});

const page = usePage();
const success = ref((page.props.flash && page.props.flash.success) || '');

const availableTimes = computed(() => {
  if (!form.value.date || !props.event) return [];
  const weekday = new Date(form.value.date).getDay();
  const slots = props.availabilities.filter(a => a.weekday === weekday);
  let times = [];
  slots.forEach(slot => {
    let start = slot.start_time;
    let end = slot.end_time;
    let [h, m] = start.split(':').map(Number);
    let [eh, em] = end.split(':').map(Number);
    const duration = props.event.duration;
    while (h < eh || (h === eh && m + duration <= em)) {
      const time = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
      const blocked = props.blockedPeriods.some(b => form.value.date >= b.start_date && form.value.date <= b.end_date);
      const taken = props.appointments.some(a => a.start_datetime.startsWith(form.value.date) && a.start_datetime.substr(11,5) === time);
      if (!blocked && !taken) times.push(time);
      m += duration;
      if (m >= 60) { h++; m -= 60; }
    }
  });
  return times;
});

function submit() {
  const start_datetime = `${form.value.date} ${form.value.time}`;
  const end = new Date(`${form.value.date}T${form.value.time}`);
  end.setMinutes(end.getMinutes() + props.event.duration);
  const end_datetime = `${form.value.date} ${String(end.getHours()).padStart(2, '0')}:${String(end.getMinutes()).padStart(2, '0')}`;
  router.post(`/book/${props.event.slug}`, {
    name: form.value.name,
    email: form.value.email,
    start_datetime,
    end_datetime,
    ...form.value.custom,
  });
}
</script> 