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
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Panel de Administración
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stat Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Entradas Vendidas</div>
                        <div class="text-3xl font-black text-gray-900 dark:text-white mt-1">{{ stats.total_tickets_sold }}</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Recaudación Total</div>
                        <div class="text-3xl font-black text-gray-900 dark:text-white mt-1">{{ stats.total_revenue.toFixed(2) }}€</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuarios Registrados</div>
                        <div class="text-3xl font-black text-gray-900 dark:text-white mt-1">{{ stats.total_users }}</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Partidos Activos</div>
                        <div class="text-3xl font-black text-gray-900 dark:text-white mt-1">{{ stats.active_matches }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Tickets -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6 border-b dark:border-gray-700">
                            <h3 class="font-bold text-gray-900 dark:text-white">Ventas Recientes</h3>
                        </div>
                        <div class="p-6">
                            <div v-for="ticket in stats.recent_tickets" :key="ticket.id" class="flex justify-between items-center mb-4 pb-4 border-b dark:border-gray-700 last:border-0 last:mb-0 last:pb-0">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ ticket.user.name }}</div>
                                    <div class="text-xs text-gray-500">{{ ticket.match.home_team.name }} vs {{ ticket.match.away_team.name }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600">{{ ticket.price_paid }}€</div>
                                    <div class="text-[10px] text-gray-400">{{ new Date(ticket.created_at).toLocaleString() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Users -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6 border-b dark:border-gray-700">
                            <h3 class="font-bold text-gray-900 dark:text-white">Usuarios más Activos</h3>
                        </div>
                        <div class="p-6">
                            <div v-for="user in stats.top_users" :key="user.id" class="flex justify-between items-center mb-4 pb-4 border-b dark:border-gray-700 last:border-0 last:mb-0 last:pb-0">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-blue-600 font-bold mr-3">
                                        {{ user.name[0] }}
                                    </div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ user.name }}</div>
                                </div>
                                <div class="font-bold text-yellow-600">{{ user.points }} pts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
