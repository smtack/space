<script setup>
import { Link, router } from '@inertiajs/vue3';

const props = defineProps(['user']);

const redirect = () => {
    router.get(route('profile.index', props.user.username));
}
</script>

<template>
    <div @click="redirect" class="p-6 flex space-x-2 border-b border-gray-200 dark:border-gray-900 hover:bg-gray-200 hover:cursor-pointer dark:bg-gray-800 dark:hover:bg-gray-700">
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
                        <span class="text-gray-800 dark:text-gray-400 hover:underline">{{ user.name }}</span>
                        <span class="text-sm ml-2 text-gray-600 dark:text-gray-300 hover:underline">@{{ user.username }}</span>
                    </Link>
                </div>
            </div>

            <p class="mt-4 text-md text-gray-800 dark:text-gray-300">{{ user.bio }}</p>
        </div>
    </div>
</template>
