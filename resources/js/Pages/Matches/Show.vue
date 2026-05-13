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

const selectSeat = (seat) => {
    if (seat.match_seats[0].status === 'available') {
        selectedSeat.value = seat;
        form.match_seat_id = seat.match_seats[0].id;
    }
};

const lockAndBuy = () => {
    if (!form.match_seat_id) return;
    
    // First lock the seat
    axios.post(route('seats.lock'), {
        match_seat_id: form.match_seat_id
    }).then(response => {
        // Then proceed to purchase
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
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ match.home_team.name }} vs {{ match.away_team.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Seat Map -->
                            <div class="lg:col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 text-center uppercase tracking-widest">Terreno de Juego</h3>
                                <div class="bg-green-100 dark:bg-green-900/30 border-2 border-green-500 rounded-lg p-8 mb-8 text-center text-green-700 dark:text-green-300 font-bold">
                                    CAMPO
                                </div>

                                <div v-for="sector in match.stadium.sectors" :key="sector.id" class="mb-8">
                                    <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                                        {{ sector.name }} (x{{ sector.price_modifier }})
                                    </h4>
                                    <div class="grid grid-cols-10 gap-2 justify-center">
                                        <button
                                            v-for="seat in sector.seats"
                                            :key="seat.id"
                                            @click="selectSeat(seat)"
                                            :disabled="seat.match_seats[0].status !== 'available'"
                                            class="w-8 h-8 rounded-t-lg transition-all duration-200"
                                            :class="{
                                                'bg-blue-500 hover:bg-blue-600': seat.match_seats[0].status === 'available' && selectedSeat?.id !== seat.id,
                                                'bg-gray-300 cursor-not-allowed': seat.match_seats[0].status !== 'available',
                                                'bg-yellow-400 ring-4 ring-yellow-200 scale-110': selectedSeat?.id === seat.id
                                            }"
                                            :title="`${seat.row} - ${seat.number}`"
                                        >
                                            <span class="sr-only">{{ seat.number }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Purchase Summary -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-xl border border-gray-200 dark:border-gray-700 h-fit sticky top-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Resumen de Selección</h3>
                                
                                <div v-if="selectedSeat" class="space-y-4">
                                    <div class="flex justify-between border-b border-gray-200 dark:border-gray-600 pb-2">
                                        <span class="text-gray-600 dark:text-gray-400">Sector</span>
                                        <span class="font-bold dark:text-white">{{ selectedSeat.sector.name }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-gray-200 dark:border-gray-600 pb-2">
                                        <span class="text-gray-600 dark:text-gray-400">Fila / Asiento</span>
                                        <span class="font-bold dark:text-white">{{ selectedSeat.row }} / {{ selectedSeat.number }}</span>
                                    </div>
                                    <div class="flex justify-between text-xl pt-4">
                                        <span class="font-bold dark:text-white">Precio Total</span>
                                        <span class="font-black text-blue-600 dark:text-blue-400">{{ (match.base_price * selectedSeat.sector.price_modifier).toFixed(2) }}€</span>
                                    </div>

                                    <button
                                        @click="lockAndBuy"
                                        class="w-full py-4 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold text-lg shadow-lg shadow-green-500/20 transition-all active:scale-95"
                                    >
                                        Pagar Ahora
                                    </button>
                                    <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-4 italic">
                                        * El asiento se reservará durante 10 minutos al iniciar el pago.
                                    </p>
                                </div>
                                <div v-else class="text-center py-12 text-gray-500 dark:text-gray-400 italic">
                                    Selecciona un asiento en el mapa para continuar.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
