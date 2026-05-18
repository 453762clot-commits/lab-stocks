<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-[#020617] font-sans antialiased text-slate-200">
        <nav class="sticky top-0 z-[100] border-b border-white/5 bg-[#020617]/80 backdrop-blur-xl">
            <!-- Primary Navigation Menu -->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 justify-between">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('dashboard')" class="flex items-center space-x-3 group">
                                <div class="bg-blue-600 p-2 rounded-xl shadow-lg shadow-blue-600/30 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                </div>
                                <span class="text-xl font-black text-white uppercase tracking-tighter">Stadium<span class="text-blue-500">Pass</span></span>
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:ms-12 sm:flex">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="text-xs font-black uppercase tracking-widest transition-colors">
                                Inicio
                            </NavLink>
                            <NavLink :href="route('matches.index')" :active="route().current('matches.*')" class="text-xs font-black uppercase tracking-widest transition-colors">
                                Partidos
                            </NavLink>
                            <NavLink :href="route('ranking.index')" :active="route().current('ranking.index')" class="text-xs font-black uppercase tracking-widest transition-colors">
                                Ranking
                            </NavLink>
                            <NavLink v-if="$page.props.auth.user.role === 'admin'" :href="route('admin.dashboard')" :active="route().current('admin.*')" class="text-xs font-black uppercase tracking-widest text-emerald-400">
                                Administración
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <div class="flex items-center space-x-4 bg-white/5 px-4 py-2 rounded-2xl border border-white/10 mr-4">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Puntos: <span class="text-white ml-1">{{ $page.props.auth.user.points }}</span></span>
                        </div>
                        
                        <!-- Settings Dropdown -->
                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button type="button" class="inline-flex items-center space-x-3 text-sm font-bold text-white transition hover:text-blue-400 focus:outline-none">
                                        <span>{{ $page.props.auth.user.name }}</span>
                                        <div class="w-10 h-10 bg-blue-600/20 rounded-xl flex items-center justify-center border border-blue-500/30">
                                            <span class="text-blue-400">{{ $page.props.auth.user.name[0] }}</span>
                                        </div>
                                    </button>
                                </template>

                                <template #content>
                                    <div class="bg-[#0f172a] border border-white/10 overflow-hidden rounded-xl shadow-2xl">
                                        <DropdownLink :href="route('profile.edit')" class="text-slate-300 hover:bg-white/5 hover:text-white transition-colors">Mi Perfil</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button" class="text-red-400 hover:bg-red-500/10 transition-colors">Cerrar Sesión</DropdownLink>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="p-2 text-slate-400 hover:text-white focus:outline-none transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="sm:hidden bg-[#020617] border-t border-white/5">
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Inicio</ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('matches.index')" :active="route().current('matches.index')">Partidos</ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('ranking.index')" :active="route().current('ranking.index')">Ranking</ResponsiveNavLink>
                </div>
                <div class="border-t border-white/5 pb-1 pt-4">
                    <div class="px-4">
                        <div class="text-base font-bold text-white">{{ $page.props.auth.user.name }}</div>
                        <div class="text-sm font-medium text-slate-500">{{ $page.props.auth.user.email }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">Perfil</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">Cerrar Sesión</ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-gradient-to-b from-[#020617] to-transparent py-12" v-if="$slots.header">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
