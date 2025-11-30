<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SimplePagination from '@/Components/SimplePagination.vue';
import { Head, router } from '@inertiajs/vue3';
import UserIcon from '@/Components/Icons/UserIcon.vue';
import ReplyIcon from '@/Components/Icons/ReplyIcon.vue';
import LikeIcon from '@/Components/Icons/LikeIcon.vue';
import SpaceIcon from '@/Components/Icons/SpaceIcon.vue';

const props = defineProps({
    profile: Object,
    posts: Object,
});

const follow = () => {
    router.post(route('users.follow', props.profile.id));
};

const unfollow = () => {
    router.post(route('users.unfollow', props.profile.id));
};
</script>

<template>
    <Head :title="`${profile.name}'s Profile`" />

    <AuthenticatedLayout>
        <div class="flex flex-col sm:flex-row gap-6 sm:gap-8 p-6 items-start border-b border-gray-300">
            <div class="shrink-0">
                <img
                    class="h-12 w-12 text-gray-600 rounded-full"
                    :src="`/storage/avatars/${profile.avatar}`"
                    alt="Avatar"
                />
            </div>
            <div class="flex-1 min-w-0">
                <div class="space-y-1">
                    <h1 class="block text-gray-800 truncate">{{ profile.name }}</h1>
                    <h2 class="block text-sm text-gray-400">@{{ profile.username }}</h2>
                    <h3 class="block mt-4 text-sm text-gray-600">Joined on {{ new Date(profile.created_at).toDateString() }}</h3>
                </div>

                <p class="my-4 text-sm text-gray-800 leading-relaxed">
                    {{ profile.bio }}
                </p>

                <div v-if="profile.id !== $page.props.auth.user.id">
                    <SecondaryButton v-if="$page.props.auth.user.follows" @click="unfollow">Unfollow</SecondaryButton>
                    <PrimaryButton v-else @click="follow">Follow</PrimaryButton>
                </div>

                <div class="mt-8">
                    <div class="flex justify-between">
                        <div class="flex items-center gap-2">
                            <UserIcon />
                            <span>{{ profile.followers }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <SpaceIcon />
                            <span>{{ profile.posts }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <ReplyIcon />
                            <span>{{ profile.replies }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <LikeIcon />
                            <span>{{ profile.likes }}</span>
                        </div>
                    </div>
                </div>
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
