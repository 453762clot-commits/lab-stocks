<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    userRank: Number,
    activeTicketsCount: Number,
    points: Number,
    tickets: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">
                        Panel de <span class="text-blue-500">Control</span>
                    </h2>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Bienvenido de nuevo, {{ $page.props.auth.user.name }}</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Welcome Banner -->
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-900 rounded-[2.5rem] p-12 mb-8 shadow-2xl shadow-blue-500/20">
                    <div class="relative z-10 max-w-2xl">
                        <h3 class="text-4xl font-black text-white mb-4 leading-tight italic uppercase tracking-tighter">
                            ¡Prepárate para la <br/>próxima jornada!
                        </h3>
                        <p class="text-blue-100 text-lg font-medium mb-8 opacity-80">
                            Explora los próximos partidos, gestiona tus entradas y compite en el ranking global de seguidores.
                        </p>
                        <Link :href="route('matches.index')" class="inline-flex items-center px-8 py-4 bg-white text-blue-900 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-blue-50 transition-all shadow-xl active:scale-95">
                            Ver Partidos Disponibles
                        </Link>
                    </div>
                    <!-- Decorative element -->
                    <div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <path d="M0 100 L100 0 L100 100 Z" fill="white"/>
                        </svg>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-blue-500/50 transition-colors group">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <h4 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-2">Puntos Acumulados</h4>
                        <p class="text-3xl font-black text-white">{{ points }} <span class="text-sm text-slate-500 uppercase tracking-tighter ml-1">pts</span></p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-emerald-500/50 transition-colors group">
                        <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <h4 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-2">Entradas Activas</h4>
                        <p class="text-3xl font-black text-white">{{ activeTicketsCount }} <span class="text-sm text-slate-500 uppercase tracking-tighter ml-1">tickets</span></p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-yellow-500/50 transition-colors group">
                        <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <h4 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-2">Posición Ranking</h4>
                        <p class="text-3xl font-black text-white">#{{ userRank }}</p>
                    </div>
                </div>

                <!-- Mis Entradas -->
                <div class="mt-12">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h4 class="text-2xl font-black text-white uppercase italic tracking-tighter">
                                Mis <span class="text-blue-500">Entradas</span>
                            </h4>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Todas tus entradas válidas para los próximos encuentros</p>
                        </div>
                    </div>

                    <div v-if="tickets.length === 0" class="bg-white/5 border border-white/10 rounded-[2rem] p-12 text-center">
                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <h5 class="text-white font-bold text-lg mb-2">Aún no tienes entradas</h5>
                        <p class="text-slate-400 text-sm mb-6 max-w-md mx-auto">Adquiere entradas para tus partidos favoritos y acumula puntos para subir en el ranking.</p>
                        <Link :href="route('matches.index')" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-blue-700 transition-colors">
                            Buscar Entradas
                        </Link>
                    </div>

                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="ticket in tickets" :key="ticket.id" class="bg-white/5 border border-white/10 rounded-[2rem] overflow-hidden hover:border-blue-500/30 transition-all flex flex-col justify-between group">
                            <!-- Match Info Header -->
                            <div class="p-6 bg-gradient-to-r from-blue-600/10 to-indigo-900/10 border-b border-white/5">
                                <span class="px-3 py-1 bg-blue-500/20 text-blue-400 text-[8px] font-black uppercase tracking-widest rounded-full border border-blue-500/30">
                                    {{ ticket.match.competition }}
                                </span>
                                <h5 class="text-white font-black text-xl italic uppercase tracking-tighter mt-3 leading-tight group-hover:text-blue-400 transition-colors">
                                    {{ ticket.match.home_team.name }} <span class="text-xs text-slate-500 block my-1">VS</span> {{ ticket.match.away_team.name }}
                                </h5>
                                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">
                                    {{ new Date(ticket.match.match_date).toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' }) }} h
                                </p>
                            </div>

                            <!-- Seat Details -->
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-slate-500 text-[8px] font-black uppercase tracking-widest mb-1">Sector</p>
                                        <p class="text-white font-black text-sm uppercase italic tracking-tighter">{{ ticket.seat.sector.name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500 text-[8px] font-black uppercase tracking-widest mb-1">Localización</p>
                                        <p class="text-white font-black text-sm uppercase italic tracking-tighter">Fila {{ ticket.seat.row }} &middot; As. {{ ticket.seat.number }}</p>
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-white/5 flex items-center justify-between">
                                    <div>
                                        <p class="text-slate-500 text-[8px] font-black uppercase tracking-widest mb-1">Pagado</p>
                                        <p class="text-emerald-400 font-bold text-sm">{{ Number(ticket.price_paid).toFixed(2) }}€</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-slate-500 text-[8px] font-black uppercase tracking-widest mb-1">Identificador</p>
                                        <p class="text-slate-400 font-mono text-[10px]">{{ ticket.uuid.split('-')[0].toUpperCase() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="p-6 bg-white/5 border-t border-white/5 grid grid-cols-2 gap-4">
                                <Link :href="route('tickets.show', { ticket: ticket.id })" class="w-full py-3 bg-white/5 border border-white/10 rounded-xl font-bold text-[10px] uppercase text-center text-white hover:bg-white/10 transition-colors tracking-widest">
                                    Ver Entrada
                                </Link>
                                <a :href="'/tickets/' + ticket.id + '/pdf'" class="w-full py-3 bg-blue-600 rounded-xl font-bold text-[10px] uppercase text-center text-white hover:bg-blue-700 transition-colors tracking-widest flex items-center justify-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M7 10l5 5m0 0l5-5m-5 5V3"/></svg>
                                    <span>Descargar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
