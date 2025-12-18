<script setup>
import BookmarkIcon from '@/Components/Icons/BookmarkIcon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import LikeIcon from '@/Components/Icons/LikeIcon.vue';
import ReplyIcon from '@/Components/Icons/ReplyIcon.vue';
import RepostIcon from '@/Components/Icons/RepostIcon.vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['post']);

const form = useForm({
    message: props.post.message,
});

const editing = ref(false);

const toggleLike = (post) => {
    const url = props.post.liked
        ? route('posts.unlike', post)
        : route('posts.like', post);
    
    router.post(url, {}, {
        reset: ['post'],
    });
}

const toggleBookmark = (post) => {
    const url = props.post.bookmarked
        ? route('posts.removeBookmark', post)
        : route('posts.bookmark', post);

    router.post(url, {}, {
        reset: ['post'],
    });
};

const toggleRepost = (post) => {
    const url = props.post.reposted
        ? route('posts.removeRepost', post)
        : route('posts.repost', post);

    router.post(url, {}, {
        reset: ['post'],
    });
};
</script>

<template>
    <div class="p-6 flex space-x-2">
        <Link :href="route('profile.index', post.user.username)">
            <img
                class="h-12 w-12 rounded-full"
                :src="`/storage/avatars/${post.user.avatar}`"
                alt="Avatar">
        </Link>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <Link :href="route('profile.index', post.user.username)">
                        <span class="text-gray-800 hover:underline">{{ post.user.name }}</span>
                        <span class="text-sm ml-2 text-gray-600 hover:underline">@{{ post.user.username }}</span>
                    </Link>
                    <small class="ml-2 text-sm text-gray-400">
                        {{ new Date(post.created_at).toLocaleDateString('en-GB', {
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric',
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: false,
                        }) }}
                    </small>
                    <small v-if="post.created_at !== post.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>
                <Dropdown v-if="post.user_id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('posts.destroy', post.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            
            <div>
                <form v-if="editing" @submit.prevent="form.put(route('posts.update', post.id), { onSuccess: () => editing = false })">
                    <textarea v-model="form.message" class="mt-4 w-full p-2 text-gray-900 border border-gray-300 focus:border-red-300 focus:outline-none focus:ring focus:ring-red-200/50 rounded-md shadow-xs"></textarea>
                    <InputError :message="form.errors.message" class="mt-2" />
                    <div class="space-x-2">
                        <PrimaryButton class="mt-4">Save</PrimaryButton>
                        <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                    </div>
                </form>

                <p v-else class="mt-4 text-lg text-gray-900">{{ post.message }}</p>

                <img
                    v-if="post.image"
                    :src="`/storage/images/${post.image}`"
                    alt="Post Image"
                    class="my-4 rounded-md"
                >
            </div>
        </div>
        </div>

        <div class="px-6 py-3 border-y mt-8">
        <div class="flex justify-between">
            <div class="flex items-center gap-2">
                <LikeIcon
                    @click="toggleLike(post.id)"
                    :fill="post.liked ? '#FF2D30' : '#000000'"
                    class="hover:cursor-pointer hover:bg-red-200"
                />
                <span>{{ post.likes_count }}</span>
            </div>
            <div class="flex items-center gap-2">
                <ReplyIcon />
                <span>{{ post.replies_count }}</span>
            </div>
            <div class="flex items-center gap-2">
                <BookmarkIcon
                    @click="toggleBookmark(post.id)"
                    class="hover:cursor-pointer hover:bg-red-200"
                    :fill="post.bookmarked ? '#FF2D30' : 'none'"
                    :stroke="post.bookmarked ? '#FF2D30' : '#000000'"
                />
                <span>{{ post.bookmarks_count }}</span>
            </div>
            <div class="flex items-center gap-2">
                <RepostIcon
                    @click="toggleRepost(post.id)"
                    :color="post.reposted ? '#FF2D20' : '#000000'"
                    class="hover:cursor-pointer hover:bg-red-200"
                />
                <span>{{ post.reposts_count }}</span>
            </div>
        </div>
    </div>
</template>