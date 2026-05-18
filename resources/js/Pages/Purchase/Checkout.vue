<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    seats: Array,
    match: Object,
    total: Number,
    match_seat_ids: Array,
});

const form = useForm({
    match_seat_ids: props.match_seat_ids,
    card_number: '**** **** **** 4242',
    expiry: '12/26',
    cvv: '***',
});

const isProcessing = ref(false);

const submit = () => {
    isProcessing.value = true;
    // Simulate a delay for payment processing
    setTimeout(() => {
        form.post(route('purchase.store'));
    }, 2000);
};
</script>

<template>
    <Head title="Finalizar Compra" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">
                Finalizar <span class="text-emerald-500">Compra</span>
            </h2>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Revisa tu pedido y confirma el pago</p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    
                    <!-- Left: Order Summary -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="glass-card p-8 rounded-[2.5rem] border border-white/5 shadow-2xl">
                            <h3 class="text-white font-black uppercase tracking-widest text-xs mb-8">Resumen de Localidades</h3>
                            
                            <div class="space-y-4">
                                <div v-for="ms in seats" :key="ms.id" class="flex justify-between items-center p-6 bg-white/5 rounded-2xl border border-white/5 group hover:border-blue-500/30 transition-colors">
                                    <div class="flex items-center space-x-6">
                                        <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center border border-blue-500/30">
                                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-bold text-lg uppercase italic tracking-tighter">{{ ms.seat.sector.name }}</p>
                                            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">{{ ms.seat.row }} · {{ ms.seat.number }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-white font-black text-xl italic tracking-tighter">{{ (Number(match.base_price) * Number(ms.seat.sector.price_modifier)).toFixed(2) }}€</p>
                                        <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest italic">Multiplicador x{{ ms.seat.sector.price_modifier }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card p-8 rounded-[2.5rem] border border-white/5 bg-gradient-to-br from-blue-600/10 to-transparent">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="w-10 h-10 bg-emerald-500/20 rounded-full flex items-center justify-center border border-emerald-500/30 text-emerald-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h4 class="text-white font-bold uppercase tracking-tight text-sm">Garantía de Satisfacción StadiumPass</h4>
                            </div>
                            <p class="text-slate-400 text-xs leading-loose italic">
                                Al procesar este pago, aceptas los términos y condiciones de la plataforma. Tus entradas se generarán automáticamente y estarán disponibles en tu perfil. Se enviará una copia digital a tu dirección de correo electrónico vinculada: <span class="text-white font-bold">{{ $page.props.auth.user.email }}</span>.
                            </p>
                        </div>
                    </div>

                    <!-- Right: Payment Details -->
                    <div class="lg:col-span-1">
                        <div class="glass-card p-10 rounded-[3rem] sticky top-8 border-t-8 border-blue-600 shadow-blue-600/10">
                            <h3 class="text-white font-black text-2xl mb-12 uppercase tracking-tighter italic">Checkout</h3>
                            
                            <div class="space-y-10">
                                <!-- Card Simulation -->
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] block mb-3">Método de Pago</label>
                                        <div class="relative">
                                            <input type="text" v-model="form.card_number" class="w-full bg-white/5 border-white/10 rounded-2xl px-6 py-4 text-white font-bold tracking-widest focus:border-blue-500 outline-none transition-all" readonly>
                                            <div class="absolute right-6 top-1/2 -translate-y-1/2 flex space-x-2">
                                                <div class="w-8 h-5 bg-blue-600 rounded opacity-50"></div>
                                                <div class="w-8 h-5 bg-orange-500 rounded opacity-50"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] block mb-3">Expira</label>
                                            <input type="text" v-model="form.expiry" class="w-full bg-white/5 border-white/10 rounded-2xl px-6 py-4 text-white font-bold outline-none" readonly>
                                        </div>
                                        <div>
                                            <label class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] block mb-3">CVC</label>
                                            <input type="text" v-model="form.cvv" class="w-full bg-white/5 border-white/10 rounded-2xl px-6 py-4 text-white font-bold outline-none" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-10 border-t border-white/10 space-y-6">
                                    <div class="flex justify-between items-end">
                                        <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Total a Pagar</p>
                                        <p class="text-4xl font-black text-white italic tracking-tighter">{{ Number(total).toFixed(2) }}€</p>
                                    </div>

                                    <button 
                                        @click="submit"
                                        :disabled="isProcessing"
                                        class="w-full py-5 bg-blue-600 hover:bg-blue-500 disabled:bg-slate-800 text-white rounded-3xl font-black text-sm uppercase tracking-widest shadow-2xl shadow-blue-600/40 transition-all active:scale-95 flex items-center justify-center space-x-4 group"
                                    >
                                        <span v-if="!isProcessing">Confirmar y Pagar</span>
                                        <span v-else class="flex items-center space-x-2">
                                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Procesando...</span>
                                        </span>
                                        <svg v-if="!isProcessing" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
