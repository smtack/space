<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateAvatarForm from './Partials/UpdateAvatarForm.vue';
import UpdateBioForm from './Partials/UpdateBioForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdateAppearanceForm from './Partials/UpdateAppearanceForm.vue';
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
    <Head title="Settings" />

    <AuthenticatedLayout>
        <div>
            <div class="p-4 sm:p-8 border-b border-gray-300">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">Settings</h2>
            </div>

            <div class="p-4 sm:p-8">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div class="p-4 sm:p-8">
                <UpdateBioForm class="max-w-xl" />
            </div>

            <div class="p-4 sm:p-8">
                <UpdateAvatarForm class="max-w-xl" />
            </div>

            <div class="p-4 sm:p-8">
                <UpdateAppearanceForm class="max-w-xl" />
            </div>

            <div class="p-4 sm:p-8">
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div class="p-4 sm:p-8">
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
