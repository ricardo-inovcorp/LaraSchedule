<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Avatar } from '@/components/ui/avatar';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import Button from '@/components/ui/button/Button.vue';
import LineChart from './Dashboard/LineChart.vue';
import PieChart from './Dashboard/PieChart.vue';
import Calendar from './Dashboard/Calendar.vue';

const props = defineProps({
  totalAgendamentos: Number,
  horariosDisponiveisHoje: Number,
  bloqueiosAtivos: Number,
  proximosAgendamentos: Array,
  agendamentosPorSemana: Object,
  distribuicaoTiposEventos: Object,
});
</script>

<template>
  <Head title="Dashboard" />
  <AppLayout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 py-10 px-4">
      <!-- Cards de Métricas -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <Card class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl">
          <CardHeader>
            <CardTitle class="flex items-center gap-2 text-blue-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
              Agendamentos Futuros
            </CardTitle>
          </CardHeader>
          <CardContent>
            <div class="text-3xl font-bold text-gray-100">{{ props.totalAgendamentos }}</div>
          </CardContent>
        </Card>
        <Card class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl">
          <CardHeader>
            <CardTitle class="flex items-center gap-2 text-green-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              Disponíveis Hoje
            </CardTitle>
          </CardHeader>
          <CardContent>
            <div class="text-3xl font-bold text-gray-100">{{ props.horariosDisponiveisHoje }}</div>
          </CardContent>
        </Card>
        <Card class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl">
          <CardHeader>
            <CardTitle class="flex items-center gap-2 text-pink-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414M6.343 17.657l-1.414 1.414M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              Bloqueios Ativos
            </CardTitle>
          </CardHeader>
          <CardContent>
            <div class="text-3xl font-bold text-gray-100">{{ props.bloqueiosAtivos }}</div>
          </CardContent>
        </Card>
      </div>
      <!-- Gráficos -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <Card class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl min-h-[300px] flex flex-col">
          <CardHeader>
            <CardTitle class="text-blue-300">Agendamentos por Semana</CardTitle>
          </CardHeader>
          <CardContent class="flex-1 flex items-center justify-center">
            <LineChart :data="props.agendamentosPorSemana" />
          </CardContent>
        </Card>
        <Card class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl min-h-[300px] flex flex-col">
          <CardHeader>
            <CardTitle class="text-pink-300">Distribuição dos Tipos de Eventos</CardTitle>
          </CardHeader>
          <CardContent class="flex-1 flex items-center justify-center">
            <PieChart :data="props.distribuicaoTiposEventos" />
          </CardContent>
        </Card>
      </div>
      <!-- Calendário e Próximos Agendamentos -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <Card class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl min-h-[350px] flex items-center justify-center">
          <Calendar :agendamentos="props.proximosAgendamentos" :bloqueios="[]" />
        </Card>
        <Card class="bg-white/10 backdrop-blur-md border border-white/20 shadow-xl">
          <CardHeader>
            <CardTitle class="text-purple-400">Próximos Agendamentos</CardTitle>
          </CardHeader>
          <CardContent>
            <ul class="divide-y divide-gray-700">
              <li v-for="a in props.proximosAgendamentos" :key="a.id" class="py-3 flex flex-col gap-1">
                <div class="flex items-center gap-2">
                  <span class="font-semibold text-gray-100">{{ a.event_id }}</span>
                  <span class="text-xs text-gray-400">{{ a.start_datetime }}</span>
                </div>
                <span class="text-sm text-gray-400">Cliente: {{ a.name }}</span>
              </li>
            </ul>
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>
