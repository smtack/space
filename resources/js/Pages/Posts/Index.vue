<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import SimplePagination from '@/Components/SimplePagination.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    posts: Object
});
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <div class="divide-y">
            <Post
                v-for="post in posts.data"
                :key="post.id"
                :post="post"
            />

            <SimplePagination :pagination="posts" />
        </div>
    </AuthenticatedLayout>
</template>
