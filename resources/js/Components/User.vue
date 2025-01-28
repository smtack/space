<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps(['user']);

const redirect = () => {
    router.get(route('profile.index', props.user.username));
}
</script>

<template>
    <div @click="redirect" class="p-6 flex space-x-2 hover:bg-gray-100 hover:cursor-pointer">
        <Link v-on:click.stop :href="route('profile.index', user.username)">
            <img
                class="h-12 w-12 rounded-full"
                :src="`/storage/avatars/${user.avatar}`"
                alt="Avatar">
        </Link>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <Link v-on:click.stop :href="route('profile.index', user.username)">
                        <span class="text-gray-800 hover:underline">{{ user.name }}</span>
                        <span class="text-sm ml-2 text-gray-600 hover:underline">@{{ user.username }}</span>
                    </Link>
                </div>
                <!-- <Dropdown v-if="post.user_id === $page.props.auth.user.id" v-on:click.stop>
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
                </Dropdown> -->
            </div>
            <p class="mt-4 text-md text-gray-900">{{ user.bio }}</p>
        </div>
    </div>
</template>
