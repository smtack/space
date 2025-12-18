<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import { InfiniteScroll, Head } from '@inertiajs/vue3';

const props = defineProps({
    posts: Object
});
</script>

<template>
    <Head title="Likes" />

    <AuthenticatedLayout>
        <div class="divide-y">
            <InfiniteScroll data="posts">
                <Post
                    v-for="post in posts.data"
                    :key="post.id"
                    :post="post"
                />
            </InfiniteScroll>
        </div>
    </AuthenticatedLayout>
</template>
