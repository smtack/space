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
                <p class="my-4 text-sm text-gray-800">{{ profile.bio }}</p>

                <div v-if="profile.id !== $page.props.auth.user.id">
                    <SecondaryButton v-if="$page.props.auth.user.follows" @click="unfollow">Unfollow</SecondaryButton>
                    <PrimaryButton v-else @click="follow">Follow</PrimaryButton>
                </div>

                <div class="mt-8 flex justify-items-start gap-1">
                    <UserIcon />{{ profile.followers }}
                    <SpaceIcon class="ml-2" />{{ profile.posts }}
                    <ReplyIcon class="ml-2" />{{ profile.replies }}
                    <LikeIcon class="ml-2" />{{ profile.likes }}
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
