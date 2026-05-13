<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    ranking: Array,
});
</script>

<template>
    <Head title="Ranking de Seguidores" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Ranking Global de Seguidores
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="px-6 py-4 font-bold text-gray-900 dark:text-white">Posición</th>
                                    <th class="px-6 py-4 font-bold text-gray-900 dark:text-white">Usuario</th>
                                    <th class="px-6 py-4 font-bold text-gray-900 dark:text-white">Puntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in ranking" :key="user.id" class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span v-if="index === 0" class="text-2xl">🥇</span>
                                        <span v-else-if="index === 1" class="text-2xl">🥈</span>
                                        <span v-else-if="index === 2" class="text-2xl">🥉</span>
                                        <span v-else class="text-gray-600 dark:text-gray-400 font-bold ml-2">#{{ index + 1 }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ user.name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">
                                            {{ user.points }} pts
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
