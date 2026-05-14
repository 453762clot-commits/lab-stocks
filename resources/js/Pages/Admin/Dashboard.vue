<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    stats: Object,
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">
                        Panel de <span class="text-emerald-500">Administración</span>
                    </h2>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Gestión global de la plataforma</p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stat Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-blue-500/50 transition-colors group">
                        <div class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-4">Entradas Vendidas</div>
                        <div class="text-4xl font-black text-white italic tracking-tighter">{{ stats?.total_tickets_sold || 0 }}</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-emerald-500/50 transition-colors group">
                        <div class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-4">Recaudación Total</div>
                        <div class="text-4xl font-black text-white italic tracking-tighter">{{ Number(stats?.total_revenue || 0).toFixed(2) }}€</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-purple-500/50 transition-colors group">
                        <div class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-4">Usuarios Registrados</div>
                        <div class="text-4xl font-black text-white italic tracking-tighter">{{ stats?.total_users || 0 }}</div>
                    </div>
                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-yellow-500/50 transition-colors group">
                        <div class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-4">Partidos Activos</div>
                        <div class="text-4xl font-black text-white italic tracking-tighter">{{ stats?.active_matches || 0 }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Tickets -->
                    <div class="bg-white/5 border border-white/10 rounded-[2.5rem] overflow-hidden backdrop-blur-sm shadow-2xl">
                        <div class="p-8 border-b border-white/10 flex justify-between items-center">
                            <h3 class="font-black text-white uppercase tracking-widest text-xs">Ventas Recientes</h3>
                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[10px] font-black rounded-full uppercase tracking-widest">En tiempo real</span>
                        </div>
                        <div class="p-8">
                            <div v-for="ticket in stats?.recent_tickets" :key="ticket.id" class="flex justify-between items-center mb-6 pb-6 border-b border-white/5 last:border-0 last:mb-0 last:pb-0">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10">
                                        <span class="text-blue-400 font-bold">{{ ticket.user?.name[0] }}</span>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-sm tracking-tight">{{ ticket.user?.name }}</div>
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">{{ ticket.match?.home_team?.name }} vs {{ ticket.match?.away_team?.name }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-black text-emerald-400 italic tracking-tighter text-lg">{{ ticket.price_paid }}€</div>
                                    <div class="text-[10px] text-slate-500 uppercase font-bold">{{ new Date(ticket.created_at).toLocaleDateString() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Users -->
                    <div class="bg-white/5 border border-white/10 rounded-[2.5rem] overflow-hidden backdrop-blur-sm shadow-2xl">
                        <div class="p-8 border-b border-white/10 flex justify-between items-center">
                            <h3 class="font-black text-white uppercase tracking-widest text-xs">Líderes de la Comunidad</h3>
                            <span class="px-3 py-1 bg-blue-500/10 text-blue-500 text-[10px] font-black rounded-full uppercase tracking-widest">Top Usuarios</span>
                        </div>
                        <div class="p-8">
                            <div v-for="user in stats?.top_users" :key="user.id" class="flex justify-between items-center mb-6 pb-6 border-b border-white/5 last:border-0 last:mb-0 last:pb-0">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center border border-blue-500/30">
                                        <span class="text-blue-400 font-bold uppercase">{{ user.name[0] }}</span>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white text-sm tracking-tight">{{ user.name }}</div>
                                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest italic">Miembro Premium</div>
                                    </div>
                                </div>
                                <div class="font-black text-yellow-500 italic tracking-tighter text-lg">{{ user.points }} <span class="text-[10px] text-slate-500 uppercase ml-1">pts</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
