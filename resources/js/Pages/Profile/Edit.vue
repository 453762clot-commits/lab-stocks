<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">
                Mi <span class="text-blue-500">Perfil</span>
            </h2>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Gestiona tu información personal y seguridad</p>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
                <div class="bg-white/5 border border-white/10 p-8 shadow-2xl sm:rounded-[2rem] backdrop-blur-sm">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="bg-white/5 border border-white/10 p-8 shadow-2xl sm:rounded-[2rem] backdrop-blur-sm">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="bg-red-500/5 border border-red-500/10 p-8 shadow-2xl sm:rounded-[2rem] backdrop-blur-sm">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
