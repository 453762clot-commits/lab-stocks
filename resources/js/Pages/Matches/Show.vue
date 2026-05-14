<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    match: Object,
});

const selectedSeat = ref(null);

const form = useForm({
    match_seat_id: null,
});

const selectSeat = (seat, sector) => {
    const matchSeat = seat.match_seats?.[0];
    if (matchSeat && matchSeat.status === 'available') {
        selectedSeat.value = { ...seat, sector };
        form.match_seat_id = matchSeat.id;
    }
};

const lockAndBuy = () => {
    if (!form.match_seat_id) return;
    
    axios.post(route('seats.lock'), {
        match_seat_id: form.match_seat_id
    }).then(response => {
        form.post(route('purchase.store'));
    }).catch(error => {
        alert(error.response.data.message || 'Error al reservar el asiento');
    });
};
</script>

<template>
    <Head :title="`${match.home_team.name} vs ${match.away_team.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <div class="text-right">
                        <h3 class="text-white font-black text-2xl uppercase italic tracking-tighter">{{ match.home_team.name }}</h3>
                    </div>
                    <div class="bg-blue-600 text-white font-black px-3 py-1 rounded italic text-xl">VS</div>
                    <div class="text-left">
                        <h3 class="text-white font-black text-2xl uppercase italic tracking-tighter">{{ match.away_team.name }}</h3>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-blue-400 font-bold text-xs uppercase tracking-widest">{{ match.competition }}</p>
                    <p class="text-slate-400 text-sm">{{ match.stadium?.name }}</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    
                    <!-- Left Sidebar: Legends -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="glass-card p-6 rounded-3xl">
                            <h4 class="text-white font-black uppercase tracking-widest text-xs mb-6">Estado de Asientos</h4>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3 text-sm">
                                    <div class="w-4 h-4 rounded bg-blue-500 shadow-lg shadow-blue-500/50"></div>
                                    <span class="text-slate-300">Disponible</span>
                                </div>
                                <div class="flex items-center space-x-3 text-sm">
                                    <div class="w-4 h-4 rounded bg-emerald-500 shadow-lg shadow-emerald-500/50"></div>
                                    <span class="text-slate-300">Seleccionado</span>
                                </div>
                                <div class="flex items-center space-x-3 text-sm">
                                    <div class="w-4 h-4 rounded bg-slate-700"></div>
                                    <span class="text-slate-500 line-through">Ocupado</span>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card p-6 rounded-3xl border-l-4 border-blue-500">
                            <h4 class="text-white font-black uppercase tracking-widest text-xs mb-2">Información de Precios</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                El precio final se calcula multiplicando el precio base del partido ({{ match.base_price }}€) por el multiplicador del sector seleccionado.
                            </p>
                        </div>
                    </div>

                    <!-- Main Area: Stadium Map -->
                    <div class="lg:col-span-2">
                        <div class="stadium-map-container">
                            <div class="stadium-map-inner bg-slate-900/50 p-8 rounded-[4rem] border border-white/5 shadow-3xl">
                                <!-- Pitch -->
                                <div class="relative w-full h-32 bg-emerald-600/20 border-2 border-emerald-500/30 rounded-xl mb-12 overflow-hidden flex items-center justify-center">
                                    <div class="absolute inset-0 opacity-20" style="background-image: repeating-linear-gradient(90deg, transparent, transparent 40px, rgba(255,255,255,0.1) 40px, rgba(255,255,255,0.1) 80px);"></div>
                                    <div class="w-16 h-16 border-2 border-emerald-500/30 rounded-full flex items-center justify-center">
                                        <div class="w-1 h-1 bg-emerald-500/30 rounded-full"></div>
                                    </div>
                                    <span class="absolute text-emerald-500/50 font-black uppercase tracking-[1em] text-xs">Terreno de Juego</span>
                                </div>

                                <!-- Sectors -->
                                <div class="space-y-12">
                                    <div v-for="sector in match.stadium?.sectors" :key="sector.id" class="relative">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Sector {{ sector.name }}</span>
                                            <span class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Multiplicador x{{ sector.price_modifier.toFixed(2) }}</span>
                                        </div>
                                        <div class="grid grid-cols-10 gap-3 justify-center">
                                            <button
                                                v-for="seat in sector.seats"
                                                :key="seat.id"
                                                @click="selectSeat(seat, sector)"
                                                :disabled="seat.match_seats?.[0]?.status !== 'available'"
                                                class="relative aspect-square rounded-lg transition-all duration-300 transform hover:scale-125 group"
                                                :class="{
                                                    'bg-blue-600/20 border border-blue-500/50 hover:bg-blue-600 hover:shadow-xl hover:shadow-blue-600/50': seat.match_seats?.[0]?.status === 'available' && selectedSeat?.id !== seat.id,
                                                    'bg-slate-800 border border-white/5 opacity-30 cursor-not-allowed': seat.match_seats?.[0]?.status !== 'available',
                                                    'bg-emerald-500 border-2 border-white shadow-xl shadow-emerald-500/50 scale-125 z-20': selectedSeat?.id === seat.id
                                                }"
                                            >
                                                <div v-if="seat.match_seats?.[0]?.status === 'available'" class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white text-slate-900 text-[10px] font-black px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-xl">
                                                    {{ seat.row }} - {{ seat.number }}
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar: Purchase Summary -->
                    <div class="lg:col-span-1">
                        <div class="glass-card p-8 rounded-[2rem] sticky top-8 border-t-4 border-emerald-500 shadow-emerald-500/10">
                            <h3 class="text-white font-black text-xl mb-8 uppercase tracking-tighter">Resumen</h3>
                            
                            <div v-if="selectedSeat" class="space-y-6">
                                <div class="space-y-1">
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Zona Seleccionada</p>
                                    <p class="text-white font-bold text-lg">{{ selectedSeat.sector.name }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Localidad</p>
                                    <p class="text-white font-bold text-lg">{{ selectedSeat.row }} · {{ selectedSeat.number }}</p>
                                </div>

                                <div class="pt-6 border-t border-white/10 space-y-4">
                                    <div class="flex justify-between items-end">
                                        <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Inversión Total</p>
                                        <p class="text-3xl font-black gradient-text">{{ (match.base_price * selectedSeat.sector.price_modifier).toFixed(2) }}€</p>
                                    </div>
                                    <button
                                        @click="lockAndBuy"
                                        class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-emerald-600/30 transition-all active:scale-95 group flex items-center justify-center space-x-2"
                                    >
                                        <span>Procesar Pago</span>
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </button>
                                </div>
                                <p class="text-[10px] text-center text-slate-500 italic uppercase tracking-wider">
                                    Seguridad Garantizada · Bloqueo de 10 min.
                                </p>
                            </div>
                            <div v-else class="text-center py-20">
                                <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/10 animate-pulse-soft">
                                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                </div>
                                <p class="text-slate-400 text-sm font-bold uppercase tracking-tighter leading-tight px-4">
                                    Selecciona una localidad en el mapa para continuar
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
