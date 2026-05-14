<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    matches: Array,
});

const selectedCompetition = ref('Todas');

const competitions = computed(() => {
    const comps = ['Todas', ...new Set(props.matches.map(m => m.competition))];
    return comps;
});

const filteredMatches = computed(() => {
    if (selectedCompetition.value === 'Todas') {
        return props.matches;
    }
    return props.matches.filter(m => m.competition === selectedCompetition.value);
});
</script>

<template>
    <Head title="Cartelera de Partidos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end space-y-4 md:space-y-0">
                <div>
                    <p class="text-blue-400 font-bold uppercase tracking-widest text-xs mb-1">Experiencia LAB Stocks</p>
                    <h2 class="font-black text-4xl text-white leading-tight">
                        Próximos <span class="gradient-text">Eventos</span>
                    </h2>
                </div>
                
                <!-- Competition Filters -->
                <div class="flex flex-wrap gap-2">
                    <button 
                        v-for="comp in competitions" 
                        :key="comp"
                        @click="selectedCompetition = comp"
                        class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 border"
                        :class="selectedCompetition === comp 
                            ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-600/30' 
                            : 'bg-white/5 border-white/10 text-slate-400 hover:bg-white/10 hover:text-white'"
                    >
                        {{ comp }}
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="filteredMatches.length > 0" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div v-for="match in filteredMatches" :key="match.id" class="group relative overflow-hidden rounded-3xl bg-slate-900 border border-white/5 hover:border-blue-500/50 transition-all duration-500 shadow-2xl">
                        <!-- Background Image with Overlay -->
                        <div class="absolute inset-0 z-0">
                            <img src="/images/stadium_hero.png" class="w-full h-full object-cover opacity-30 group-hover:opacity-40 group-hover:scale-110 transition-all duration-700" />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/80 to-transparent"></div>
                        </div>

                        <div class="relative z-10 p-8 flex flex-col h-full justify-between min-h-[400px]">
                            <div>
                                <div class="flex justify-between items-start mb-8">
                                    <span class="px-3 py-1 bg-white/10 text-white text-[10px] font-black rounded-full border border-white/10 uppercase tracking-widest">
                                        {{ match.competition }}
                                    </span>
                                    <div class="text-right">
                                        <div class="text-white font-bold text-xl">{{ new Date(match.match_date).toLocaleDateString('es-ES', { day: '2-digit', month: 'short' }) }}</div>
                                        <div class="text-slate-400 text-xs uppercase tracking-widest">{{ new Date(match.match_date).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between space-x-4 mb-8 mt-4">
                                    <div class="flex-1 text-center">
                                        <div class="w-20 h-20 mx-auto mb-4 bg-white/5 rounded-3xl flex items-center justify-center border border-white/10 group-hover:border-blue-500/50 transition-all rotate-3 group-hover:rotate-0">
                                            <span class="text-3xl font-black text-white italic">{{ match.home_team.name[0] }}</span>
                                        </div>
                                        <h3 class="text-xl font-black text-white uppercase tracking-tight italic">{{ match.home_team.name }}</h3>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <div class="text-3xl font-black italic text-blue-500 mb-1 animate-pulse-soft">VS</div>
                                        <div class="h-12 w-[2px] bg-gradient-to-b from-blue-500 to-transparent"></div>
                                    </div>

                                    <div class="flex-1 text-center">
                                        <div class="w-20 h-20 mx-auto mb-4 bg-white/5 rounded-3xl flex items-center justify-center border border-white/10 group-hover:border-blue-500/50 transition-all -rotate-3 group-hover:rotate-0">
                                            <span class="text-3xl font-black text-white italic">{{ match.away_team.name[0] }}</span>
                                        </div>
                                        <h3 class="text-xl font-black text-white uppercase tracking-tight italic">{{ match.away_team.name }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-end justify-between pt-6 border-t border-white/5">
                                <div>
                                    <p class="text-slate-500 text-[10px] uppercase tracking-widest mb-1 font-black">Ubicación</p>
                                    <p class="text-white font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                        {{ match.stadium.name }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-slate-500 text-[10px] uppercase tracking-widest mb-1 text-right font-black">Tickets desde</p>
                                    <div class="flex items-center space-x-6">
                                        <span class="text-4xl font-black text-white italic tracking-tighter">{{ Number(match.base_price).toFixed(2) }}€</span>
                                        <Link :href="route('matches.show', match.id)" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-600/30 active:scale-95 group-hover:scale-105">
                                            Reservar
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-20 bg-white/5 rounded-[3rem] border border-white/5">
                    <p class="text-slate-500 font-bold uppercase tracking-widest">No hay partidos disponibles para esta competición</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
