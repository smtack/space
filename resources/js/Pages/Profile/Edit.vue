<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateAvatarForm from './Partials/UpdateAvatarForm.vue';
import UpdateBioForm from './Partials/UpdateBioForm.vue';
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
    <Head title="Edit Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Edit Profile
            </h2>
        </template>

        <div>
            <div
                class="p-4 sm:p-8 dark:bg-gray-800"
            >
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div
                class="p-4 sm:p-8 dark:bg-gray-800"
            >
                <UpdateBioForm class="max-w-xl" />
            </div>

            <div
                class="p-4 sm:p-8 dark:bg-gray-800"
            >
                <UpdateAvatarForm class="max-w-xl" />
            </div>

            <div
                class="p-4 sm:p-8 dark:bg-gray-800"
            >
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div
                class="p-4 sm:p-8 dark:bg-gray-800"
            >
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
