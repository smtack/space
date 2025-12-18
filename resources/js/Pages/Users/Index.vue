<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import User from '@/Components/User.vue';
import { InfiniteScroll, Head } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
});
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div>
            <InfiniteScroll data="users">
                <User
                    v-for="user in users.data"
                    :key="user.id"
                    :user="user"
                />
            </InfiniteScroll>
        </div>
    </AuthenticatedLayout>
</template>
