<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    ranking: Array,
});
</script>

<template>
    <Head title="Ranking de Seguidores" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">
                    Ranking <span class="text-blue-500">Global</span>
                </h2>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Los seguidores más activos de la plataforma</p>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white/5 border border-white/10 overflow-hidden rounded-[2.5rem] shadow-2xl backdrop-blur-sm">
                    <div class="p-8">
                        <table class="w-full text-left border-separate border-spacing-y-4">
                            <thead>
                                <tr class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                                    <th class="px-8 pb-4">Posición</th>
                                    <th class="px-8 pb-4">Usuario</th>
                                    <th class="px-8 pb-4">Premio Estacional</th>
                                    <th class="px-8 pb-4 text-right">Puntos Totales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in ranking" :key="user.id" 
                                    class="group transition-all duration-300 hover:translate-x-2"
                                    :class="{'bg-blue-600/10 border-l-4 border-blue-500': index === 0, 'bg-white/5': index !== 0}">
                                    <td class="px-8 py-6 rounded-l-2xl">
                                        <div class="flex items-center space-x-4">
                                            <span v-if="index === 0" class="flex items-center justify-center w-10 h-10 bg-yellow-500/20 text-yellow-500 rounded-full text-xl shadow-lg shadow-yellow-500/20">🥇</span>
                                            <span v-else-if="index === 1" class="flex items-center justify-center w-10 h-10 bg-slate-300/20 text-slate-300 rounded-full text-xl">🥈</span>
                                            <span v-else-if="index === 2" class="flex items-center justify-center w-10 h-10 bg-orange-500/20 text-orange-500 rounded-full text-xl">🥉</span>
                                            <span v-else class="flex items-center justify-center w-10 h-10 text-slate-500 font-black text-sm italic">#{{ index + 1 }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10 group-hover:border-blue-500/50 transition-colors">
                                                <span class="text-blue-400 font-bold uppercase">{{ user.name[0] }}</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-bold tracking-tight">{{ user.name }}</p>
                                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Seguidor Elite</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div v-if="index === 0">
                                            <span class="px-3 py-1 bg-yellow-500/10 text-yellow-500 text-[10px] font-black rounded-full uppercase tracking-widest border border-yellow-500/20">Abono VIP Gratis</span>
                                        </div>
                                        <div v-else-if="index < 3">
                                            <span class="px-3 py-1 bg-blue-500/10 text-blue-500 text-[10px] font-black rounded-full uppercase tracking-widest border border-blue-500/20">Camiseta Oficial</span>
                                        </div>
                                        <div v-else-if="index < 10">
                                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-500/20">Cupón -50% Dto.</span>
                                        </div>
                                        <div v-else>
                                            <span class="text-slate-600 text-[10px] font-bold uppercase tracking-widest italic">Sigue acumulando</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 rounded-r-2xl text-right">
                                        <span class="text-xl font-black italic tracking-tighter" :class="index === 0 ? 'text-yellow-500' : 'text-white'">
                                            {{ user.points }} <span class="text-[10px] text-slate-500 uppercase font-black ml-1">pts</span>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
