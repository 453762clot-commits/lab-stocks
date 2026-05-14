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
            <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">
                Tu <span class="text-blue-500">Entrada</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white/5 border border-white/10 rounded-[3rem] overflow-hidden shadow-2xl backdrop-blur-md">
                    <div class="relative h-48 bg-gradient-to-r from-blue-600 to-indigo-900 p-12 flex justify-between items-center">
                        <div>
                            <p class="text-blue-200 text-[10px] font-black uppercase tracking-[0.3em] mb-2">Ticket Digital</p>
                            <h3 class="text-4xl font-black text-white italic uppercase tracking-tighter leading-none">
                                {{ ticket.match.home_team.name }} <br/>
                                <span class="text-blue-400 text-2xl">VS</span> <br/>
                                {{ ticket.match.away_team.name }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-bold text-lg uppercase tracking-tighter">{{ ticket.match.competition }}</p>
                            <p class="text-blue-200 text-sm font-medium">{{ new Date(ticket.match.match_date).toLocaleDateString() }}</p>
                        </div>
                    </div>

                    <div class="p-12 grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="space-y-8">
                            <div class="grid grid-cols-2 gap-8">
                                <div>
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1">Zona</p>
                                    <p class="text-white font-bold text-xl uppercase italic tracking-tighter">{{ ticket.seat.sector.name }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1">Localidad</p>
                                    <p class="text-white font-bold text-xl uppercase italic tracking-tighter">{{ ticket.seat.row }} · {{ ticket.seat.number }}</p>
                                </div>
                            </div>

                            <div class="pt-8 border-t border-white/10">
                                <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1">Titular</p>
                                <p class="text-white font-bold text-lg">{{ ticket.user.name }}</p>
                                <p class="text-blue-400 font-bold text-[10px] uppercase tracking-[0.2em] mt-4">Inversión: {{ Number(ticket.price_paid).toFixed(2) }}€</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-center p-8 bg-white rounded-[2rem]">
                            <img :src="'/storage/' + ticket.qr_code_path" alt="QR Code" class="w-48 h-48 mb-4" />
                            <p class="text-slate-900 text-[10px] font-black uppercase tracking-widest">Código: {{ ticket.uuid.split('-')[0] }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/5 p-6 text-center border-t border-white/5">
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest leading-loose">
                            Presenta este código en los tornos del estadio para acceder <br/>
                            © LAB STOCKS · DIGITAL TICKETING SYSTEM
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
