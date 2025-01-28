<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import User from '@/Components/User.vue';
import SimplePagination from '@/Components/SimplePagination.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
});
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="divide-y">
            <User
                v-for="user in users.data"
                :key="user.id"
                :user="user"
            />

            <SimplePagination :pagination="users" />
        </div>
    </AuthenticatedLayout>
</template>
