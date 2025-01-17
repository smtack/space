<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import SimplePagination from '@/Components/SimplePagination.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    profile: Object,
    posts: Object,
});
</script>

<template>
    <Head :title="`${profile.name}'s Profile`" />

    <AuthenticatedLayout>
        <div class="border-b border-gray-300 p-6 flex space-x-2">
            <img
                class="h-12 w-12 text-gray-600 rounded-full"
                :src="`/storage/avatars/${profile.avatar}`"
                alt="Avatar">
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="block text-gray-800">{{ profile.name }}</span>
                        <span class="block text-sm text-gray-400">@{{ profile.username }}</span>
                        <small class="block mt-4 text-sm text-gray-600">Joined on {{ new Date(profile.created_at).toDateString() }}</small>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-800">{{ profile.bio }}</p>
            </div>
        </div>

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
