<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import User from '@/Components/User.vue';
import { Head } from '@inertiajs/vue3';

defineProps(['profile', 'posts']);
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <div>
            <User :user="profile" />
        </div>

        <div class="mt-6 divide-y">
            <Post
                v-for="post in posts"
                :key="post.id"
                :post="post"
            />
        </div>
    </AuthenticatedLayout>
</template>
