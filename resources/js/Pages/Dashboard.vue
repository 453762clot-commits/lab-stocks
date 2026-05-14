<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
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
                        <p class="text-3xl font-black text-white">{{ $page.props.auth.user.points }} <span class="text-sm text-slate-500 uppercase tracking-tighter ml-1">pts</span></p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-emerald-500/50 transition-colors group">
                        <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <h4 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-2">Entradas Activas</h4>
                        <p class="text-3xl font-black text-white">0 <span class="text-sm text-slate-500 uppercase tracking-tighter ml-1">tickets</span></p>
                    </div>

                    <div class="bg-white/5 border border-white/10 p-8 rounded-[2rem] hover:border-yellow-500/50 transition-colors group">
                        <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <h4 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-2">Posición Ranking</h4>
                        <p class="text-3xl font-black text-white">#--</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
