<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 py-12">
    <Head :title="event && event.name ? `Agendar: ${event.name}` : 'Agendamento'" />
    <div class="w-full max-w-xl bg-white/10 backdrop-blur-md rounded-3xl shadow-2xl p-10 border border-white/20">
      <template v-if="event && event.name">
        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 text-transparent bg-clip-text drop-shadow-lg mb-2">
          Agendar: {{ event.name }}
        </h1>
        <p class="mb-6 text-gray-300 text-lg">{{ event.description }}</p>
        <form @submit.prevent="submit" class="space-y-6">
          <div class="grid grid-cols-1 gap-4">
            <div>
              <label class="block mb-1 font-medium text-gray-200">Nome</label>
              <input v-model="form.name" type="text" class="w-full border-none rounded-lg px-4 py-3 bg-gray-800/80 text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 transition" required placeholder="Seu nome" />
            </div>
            <div>
              <label class="block mb-1 font-medium text-gray-200">E-mail</label>
              <input v-model="form.email" type="email" class="w-full border-none rounded-lg px-4 py-3 bg-gray-800/80 text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 transition" required placeholder="seu@email.com" />
            </div>
            <div>
              <label class="block mb-1 font-medium text-gray-200">Data</label>
              <input v-model="form.date" type="date" class="w-full border-none rounded-lg px-4 py-3 bg-gray-800/80 text-gray-100 focus:ring-2 focus:ring-blue-500 transition" required />
            </div>
            <div>
              <label class="block mb-1 font-medium text-gray-200">Horário</label>
              <select v-model="form.time" class="w-full border-none rounded-lg px-4 py-3 bg-gray-800/80 text-gray-100 focus:ring-2 focus:ring-blue-500 transition" required>
                <option value="" disabled>Selecione...</option>
                <option v-for="h in availableTimes" :key="h" :value="h">{{ h }}</option>
              </select>
            </div>
            <div v-for="field in customFields" :key="field.id">
              <label class="block mb-1 font-medium text-gray-200">{{ field.label }}<span v-if="field.required">*</span></label>
              <input v-if="field.type === 'text'" v-model="form.custom[field.id]" type="text" class="w-full border-none rounded-lg px-4 py-3 bg-gray-800/80 text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 transition" :required="field.required" />
              <!-- Adicione outros tipos conforme necessário -->
            </div>
          </div>
          <div>
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg font-semibold text-lg hover:scale-105 hover:from-blue-500 hover:to-purple-500 transition-transform duration-200">
              Agendar
            </button>
          </div>
          <div v-if="success" class="flex flex-col items-center text-green-400 mt-4 text-center font-semibold animate-pulse">
            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ success }}
          </div>
        </form>
      </template>
      <template v-else>
        <div class="text-center text-gray-400 text-lg py-12">
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

// Scroll para a mensagem de sucesso quando ela aparecer
document.addEventListener('inertia:finish', () => {
  if (success.value) {
    setTimeout(() => {
      document.querySelector('.text-green-400')?.scrollIntoView({ behavior: 'smooth' });
    }, 100);
  }
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
  }, {
    onSuccess: (page) => {
      success.value = (page.props.flash && page.props.flash.success) || '';
      form.value = { name: '', email: '', date: '', time: '', custom: {} };
      setTimeout(() => {
        document.querySelector('.text-green-400')?.scrollIntoView({ behavior: 'smooth' });
      }, 100);
    }
  });
}
</script> 