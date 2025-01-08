<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import { Head } from '@inertiajs/vue3';

defineProps(['posts']);
</script>

<template>
    <Head title="Search" />

    <AuthenticatedLayout>
        <div class="divide-y">
            <Post
                v-for="post in posts"
                :key="post.id"
                :post="post"
            />
        </div>
    </AuthenticatedLayout>
</template>
