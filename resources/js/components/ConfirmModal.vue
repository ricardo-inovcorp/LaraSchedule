<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div class="bg-gray-900 rounded-2xl shadow-2xl p-8 max-w-sm w-full border border-white/10">
      <h2 class="text-xl font-bold text-center text-pink-400 mb-4">
        <slot name="title">Confirmar ação</slot>
      </h2>
      <div class="text-gray-200 text-center mb-6">
        <slot name="message">Tem certeza que deseja continuar?</slot>
      </div>
      <div class="flex justify-center gap-4">
        <button @click="$emit('cancel')" class="px-4 py-2 rounded-xl border border-gray-700 text-gray-200 hover:bg-gray-800/50 transition">Cancelar</button>
        <button @click="$emit('confirm')" class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-500 to-pink-500 text-white font-semibold shadow hover:scale-105 transition">Confirmar</button>
      </div>
    </div>
  </div>
</template>
<script setup>
defineProps({ show: Boolean });
</script> 