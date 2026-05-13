<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    matches: Array,
});
</script>

<template>
    <Head title="Próximos Partidos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Próximos Partidos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="match in matches" :key="match.id" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ match.competition }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ new Date(match.match_date).toLocaleDateString() }}</span>
                            </div>
                            <div class="flex items-center justify-center space-x-4 mb-6">
                                <div class="text-center w-1/3">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ match.home_team.name }}</div>
                                </div>
                                <div class="text-2xl font-black text-gray-400">VS</div>
                                <div class="text-center w-1/3">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ match.away_team.name }}</div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ match.stadium.name }}
                            </div>
                            <div class="flex justify-between items-center mt-6">
                                <span class="text-2xl font-bold text-green-600 dark:text-green-400">Desde {{ match.base_price }}€</span>
                                <Link :href="route('matches.show', match.id)" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Comprar Entradas
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
