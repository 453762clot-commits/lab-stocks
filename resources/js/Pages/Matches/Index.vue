<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    matches: Array,
});
</script>

<template>
    <Head title="Cartelera de Partidos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-blue-400 font-bold uppercase tracking-widest text-xs mb-1">Experiencia LAB Stocks</p>
                    <h2 class="font-black text-4xl text-white leading-tight">
                        Próximos <span class="gradient-text">Eventos</span>
                    </h2>
                </div>
                <div class="hidden md:block text-right">
                    <span class="text-slate-400 text-sm">Mostrando {{ matches.length }} partidos disponibles</span>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div v-for="match in matches" :key="match.id" class="group relative overflow-hidden rounded-3xl bg-slate-900 border border-white/5 hover:border-blue-500/50 transition-all duration-500 shadow-2xl">
                        <!-- Background Image with Overlay -->
                        <div class="absolute inset-0 z-0">
                            <img src="/images/stadium_hero.png" class="w-full h-full object-cover opacity-30 group-hover:opacity-40 group-hover:scale-110 transition-all duration-700" />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/80 to-transparent"></div>
                        </div>

                        <div class="relative z-10 p-8 flex flex-col h-full justify-between min-h-[400px]">
                            <div>
                                <div class="flex justify-between items-start mb-8">
                                    <span class="bg-blue-600/20 text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full border border-blue-500/30">
                                        {{ match.competition }}
                                    </span>
                                    <div class="text-right">
                                        <div class="text-white font-bold text-xl">{{ new Date(match.match_date).toLocaleDateString('es-ES', { day: '2-digit', month: 'short' }) }}</div>
                                        <div class="text-slate-400 text-xs uppercase tracking-widest">{{ new Date(match.match_date).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between space-x-4 mb-8 mt-4">
                                    <div class="flex-1 text-center">
                                        <div class="w-16 h-16 mx-auto mb-3 bg-white/5 rounded-full flex items-center justify-center border border-white/10 group-hover:border-blue-500/50 transition-colors">
                                            <span class="text-2xl font-black text-white">{{ match.home_team.name[0] }}</span>
                                        </div>
                                        <h3 class="text-xl font-black text-white uppercase tracking-tight">{{ match.home_team.name }}</h3>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <div class="text-3xl font-black italic text-blue-500 mb-1">VS</div>
                                        <div class="h-10 w-[1px] bg-gradient-to-b from-blue-500 to-transparent"></div>
                                    </div>

                                    <div class="flex-1 text-center">
                                        <div class="w-16 h-16 mx-auto mb-3 bg-white/5 rounded-full flex items-center justify-center border border-white/10 group-hover:border-blue-500/50 transition-colors">
                                            <span class="text-2xl font-black text-white">{{ match.away_team.name[0] }}</span>
                                        </div>
                                        <h3 class="text-xl font-black text-white uppercase tracking-tight">{{ match.away_team.name }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-end justify-between pt-6 border-t border-white/5">
                                <div>
                                    <p class="text-slate-400 text-[10px] uppercase tracking-widest mb-1">Ubicación</p>
                                    <p class="text-white font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                        {{ match.stadium.name }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-slate-400 text-[10px] uppercase tracking-widest mb-1 text-right">Entradas desde</p>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-3xl font-black text-white">{{ match.base_price }}€</span>
                                        <Link :href="route('matches.show', match.id)" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-blue-600/30 active:scale-95">
                                            Reservar
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
