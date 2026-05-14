<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    ticket: Object,
});
</script>

<template>
    <Head title="Tu Entrada" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">
                        Tu <span class="text-blue-500">Entrada</span>
                    </h2>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Disfruta del espectáculo</p>
                </div>
                <div v-if="$page.props.flash?.success" class="bg-emerald-500/10 border border-emerald-500/20 px-6 py-3 rounded-2xl flex items-center space-x-3">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    <span class="text-emerald-500 text-[10px] font-black uppercase tracking-widest">{{ $page.props.flash.success }}</span>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white/5 border border-white/10 rounded-[3rem] overflow-hidden shadow-2xl backdrop-blur-md">
                    <!-- Ticket Header -->
                    <div class="relative h-64 bg-gradient-to-r from-blue-600 via-indigo-700 to-blue-900 p-12 flex justify-between items-center overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-blue-200 text-[10px] font-black uppercase tracking-[0.4em] mb-4">Official Digital Ticket</p>
                            <h3 class="text-5xl font-black text-white italic uppercase tracking-tighter leading-none mb-2">
                                {{ ticket.match.home_team.name }} <br/>
                                <span class="text-blue-400 text-3xl">VS</span> <br/>
                                {{ ticket.match.away_team.name }}
                            </h3>
                        </div>
                        <div class="relative z-10 text-right">
                            <div class="bg-white/10 backdrop-blur-md px-6 py-4 rounded-3xl border border-white/10">
                                <p class="text-white font-black text-xl uppercase tracking-tighter italic">{{ ticket.match.competition }}</p>
                                <p class="text-blue-200 text-sm font-bold uppercase tracking-widest mt-1">{{ new Date(ticket.match.match_date).toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' }) }}</p>
                            </div>
                        </div>
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10 pointer-events-none">
                            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <path d="M0 0 L100 100 M100 0 L0 100" stroke="white" stroke-width="0.5"/>
                            </svg>
                        </div>
                    </div>

                    <div class="p-12 grid grid-cols-1 md:grid-cols-2 gap-16">
                        <div class="space-y-10">
                            <div class="grid grid-cols-2 gap-10">
                                <div>
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-2">Sector / Zona</p>
                                    <p class="text-white font-black text-2xl uppercase italic tracking-tighter">{{ ticket.seat.sector.name }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-2">Fila / Asiento</p>
                                    <p class="text-white font-black text-2xl uppercase italic tracking-tighter">{{ ticket.seat.row }} · {{ ticket.seat.number }}</p>
                                </div>
                            </div>

                            <div class="pt-10 border-t border-white/10 flex justify-between items-start">
                                <div>
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-2">Titular de la Entrada</p>
                                    <p class="text-white font-bold text-xl">{{ ticket.user.name }}</p>
                                    <p class="text-blue-400 font-bold text-[10px] uppercase tracking-[0.2em] mt-4">Inversión: {{ Number(ticket.price_paid).toFixed(2) }}€</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-2">Estado</p>
                                    <span class="px-4 py-1 bg-emerald-500/20 text-emerald-500 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-500/30">Válida</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-center p-10 bg-white rounded-[3rem] shadow-inner shadow-slate-900/10">
                            <div class="relative group">
                                <img :src="'/storage/' + ticket.qr_code_path" alt="QR Code" class="w-56 h-56 transition-transform group-hover:scale-110" />
                                <div class="absolute inset-0 border-2 border-slate-100 rounded-2xl pointer-events-none"></div>
                            </div>
                            <p class="text-slate-900 text-[10px] font-black uppercase tracking-[0.3em] mt-8 mb-2">ID: {{ ticket.uuid.split('-')[0] }}</p>
                            <p class="text-slate-400 text-[8px] font-medium uppercase tracking-widest">Escanea en puerta</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/5 p-8 text-center border-t border-white/5">
                        <div class="flex justify-center space-x-12 mb-6">
                            <button class="text-blue-400 hover:text-white text-[10px] font-black uppercase tracking-widest transition-colors flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M7 10l5 5m0 0l5-5m-5 5V3"/></svg>
                                <span>Descargar PDF</span>
                            </button>
                            <button class="text-blue-400 hover:text-white text-[10px] font-black uppercase tracking-widest transition-colors flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <span>Añadir a Wallet</span>
                            </button>
                        </div>
                        <p class="text-slate-600 text-[8px] font-bold uppercase tracking-[0.4em] leading-loose">
                            ESTA ENTRADA ES PERSONAL E INTRANSFERIBLE · PROHIBIDA LA REVENTA <br/>
                            © LAB STOCKS · ENTERPRISE TICKETING SOLUTIONS
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
